<?php declare(strict_types=1);

namespace Xatenev\Zippify\Service;

use DateTime;
use Exception;
use FilesystemIterator;
use phpMussel\Core\Scanner;
use Psr\Log\LoggerInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use Slim\Psr7\UploadedFile;
use Xatenev\Zippify\Model\UploadItemModel;
use Xatenev\Zippify\Model\UploadMappingModel;
use Xatenev\Zippify\Model\UploadMetaModel;

class UploadService
{

    /**
     * UploadService constructor.
     *
     * @param LoggerInterface $logger
     * @param string $uploadDirectory
     * @param string $metaDirectory
     * @param string $outDirectory
     * @param Scanner $virusScanner
     */
    public function __construct(private LoggerInterface $logger,
                                private string          $uploadDirectory,
                                private string          $metaDirectory,
                                private string          $outDirectory,
                                private Scanner         $virusScanner)
    {
    }

    /**
     * Checks uploaded files for file size and file amount constraints.
     *
     * @param UploadedFile[] $uploadedFiles
     * @return bool
     */
    public function check(array $uploadedFiles): bool {
        $filesize = array_sum(array_map(fn($uploadedFile) => $uploadedFile->getSize() / (1024 * 1024), $uploadedFiles));
        $count = count($uploadedFiles);

        if($filesize > 30) {
            return false;
        }
        if($count > 64) {
            return false;
        }

        return true;
    }

    /**
     * Upload all files in given $uploadedFiles array.
     *
     * @param UploadedFile[] $uploadedFiles
     * @return UploadMappingModel
     * @throws Exception
     */
    public function upload(array $uploadedFiles): UploadMappingModel
    {
        $mapping = new UploadMappingModel();
        $mapping->setToken($this->generateUploadToken());
        $mapping->setFilepath($this->createUploadDirByToken($mapping->getToken()));
        $mapping->setItems($this->moveUploadedFiles($mapping->getFilepath(), $uploadedFiles));

        return $mapping;
    }

    /**
     * Generate a single upload token.
     *
     * @return string
     */
    private function generateUploadToken(): string
    {
        return bin2hex(openssl_random_pseudo_bytes(GENERATED_FILES_TOKEN_LENGTH));
    }

    /**
     * Create a directory by given $token for uploaded files.
     *
     * @param string $token
     * @return string
     */
    private function createUploadDirByToken(string $token): string
    {
        if (!mkdir($this->uploadDirectory . $token)) {
            $this->logger->alert(sprintf('Could not create upload directory for token [%s] and path [%s]', $token, $this->uploadDirectory . $token));
            throw new RuntimeException();
        }

        return $this->uploadDirectory . $token . DS;
    }

    /**
     * Creates a directory by given $directory and moves the uploaded files to the upload directory and
     * assigns it a unique name to avoid overwriting an existing uploaded file.
     *
     * @param string $directory directory name
     * @param UploadedFile[] $uploadedFiles file uploaded file to move
     * @return UploadItemModel[] uploaded items
     * @throws Exception
     */
    private function moveUploadedFiles(string $directory, array $uploadedFiles): array
    {
        $items = [];
        foreach ($uploadedFiles as $file) {
            if ($file->getError() === UPLOAD_ERR_OK) {
                $items[] = $this->moveUploadedFile($directory, $file);
            }
        }

        return $items;
    }

    /**
     * Moves the uploaded file to the upload directory and assigns it a unique name
     * to avoid overwriting an existing uploaded file.
     *
     * @param string $directory sub-directory to place the file in
     * @param UploadedFile $uploadedFile file uploaded file to move
     * @return UploadItemModel filename of moved file
     */
    private function moveUploadedFile(string $directory, UploadedFile $uploadedFile): UploadItemModel
    {

        $filename = sprintf('%s.%0.8s',
            bin2hex(openssl_random_pseudo_bytes(GENERATED_FILES_TOKEN_LENGTH)),
            pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION)
        );

        $uploadedFile->moveTo($directory . DS . $filename);

        return new UploadItemModel($filename, $uploadedFile->getClientFilename());
    }

    /**
     * Generate meta file as json.
     *
     * @param UploadMappingModel $uploadMapping
     */
    public function generateMeta(UploadMappingModel $uploadMapping): void
    {
        $meta = new UploadMetaModel(
            $uploadMapping->getToken(),
            $uploadMapping->getType(),
            new DateTime('+1 week'),
            filesize($this->outDirectory . $uploadMapping->getToken() . '.' . $uploadMapping->getType()),
            count($uploadMapping->getItems())
        );

        file_put_contents($this->metaDirectory . $uploadMapping->getToken() . '.json', json_encode($meta));
    }

    /**
     * Get stored meta file as json by $token.
     *
     * @param string $token
     * @return array
     */
    public function getMetaByToken(string $token): array
    {
        $meta = file_get_contents($this->metaDirectory . $token . '.json');
        if (!$meta) {
            throw new RuntimeException();
        }
        $meta = json_decode($meta, true);
        $meta['expiration'] = (new DateTime())->setTimestamp($meta['expiration']);
        return $meta;
    }

    /**
     * Removes all files in given $directory.
     *
     * @param string $directory
     */
    public function remove(string $directory): void
    {
        $it = new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }

        rmdir($directory);
    }

    /**
     * Scan all files in the provided $directory.
     *
     * @param string $directory
     * @return boolean true if everything is ok, false if something bad is found
     */
    public function virusScan(string $directory): bool
    {
        $it = new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isFile()) {
                if ($this->virusScanner->scan($file->getPathname(), 2)) {
                    $key = bin2hex(openssl_random_pseudo_bytes(QUARANTINE_KEY_LENGTH));
                    $this->virusScanner->quarantine(file_get_contents($file->getPathname()), $key, $_SERVER['REMOTE_ADDR'], $key);
                    $this->logger->alert(sprintf('Malicious data has been found, file(s) have been quarantined with key [%s]', $key));
                    // This is important, if virusScanner is not manually unset here, phpmussel runs into an endless loop and dies after 120s timeout
                    unset($this->virusScanner);

                    return false;
                }
            }
        }

        return true;
    }
}