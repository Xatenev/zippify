<?php declare(strict_types=1);

namespace Xatenev\Zippify\Service;

use Exception;
use FilesystemIterator;
use phpMussel\Core\Scanner;
use Psr\Log\LoggerInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Slim\Psr7\UploadedFile;

class UploadService
{

    public function __construct(private LoggerInterface $logger, private string $uploadDirectory, private Scanner $virusScanner)
    {
    }

    /**
     * Creates a directory by given $directory and moves the uploaded files to the upload directory and
     * assigns it a unique name to avoid overwriting an existing uploaded file.
     *
     * @param UploadedFile[] $uploadedFiles file uploaded file to move
     * @return string directory name
     * @throws Exception
     */
    public function moveUploadedFiles(array $uploadedFiles)
    {

        $directory = bin2hex(random_bytes(GENERATED_FILES_TOKEN_LENGTH));
        $fullyQualifiedDirectoryName = $this->uploadDirectory . $directory;
        mkdir($fullyQualifiedDirectoryName);

        foreach ($uploadedFiles as $file) {
            if ($file->getError() === UPLOAD_ERR_OK) {
                $this->moveUploadedFile($fullyQualifiedDirectoryName, $file);
            }
        }

        return $fullyQualifiedDirectoryName;
    }


    /**
     * Moves the uploaded file to the upload directory and assigns it a unique name
     * to avoid overwriting an existing uploaded file.
     *
     * @param string $directory sub-directory to place the file in
     * @param UploadedFile $uploadedFile file uploaded file to move
     * @return string filename of moved file
     * @throws Exception
     */
    public function moveUploadedFile(string $directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(GENERATED_FILES_TOKEN_LENGTH));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DS . $filename);

        return $directory . DS . $filename;
    }

    public function remove(string $directory)
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
     * @return bool If malicious data is found, returns true, else false
     * @throws Exception
     */
    public function virusScan(string $directory): bool
    {

        $result = false;
        $it = new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isFile()) {
                $result = $this->virusScanner->scan($file->getPathname(), 2);
                if($result) {
                    $key = bin2hex(random_bytes(QUARANTINE_KEY_LENGTH));
                    $this->virusScanner->quarantine(file_get_contents($file->getPathname()), $key, $_SERVER['REMOTE_ADDR'], $key);
                    $this->logger->alert(sprintf('Malicious data has been found, file(s) have been quarantined with key [%s]', $key));
                    break;
                }
            }
        }

        return $result;
    }
}