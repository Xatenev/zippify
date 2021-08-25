<?php declare(strict_types=1);

namespace Xatenev\Zippify\Service;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Slim\Psr7\UploadedFile;

class UploadService
{

    public function __construct(private string $uploadDirectory)
    {
    }

    /**
     * Creates a directory by given $directory and moves the uploaded files to the upload directory and
     * assigns it a unique name to avoid overwriting an existing uploaded file.
     *
     * @param UploadedFile[] $uploadedFiles file uploaded file to move
     * @return string directory name
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
        $it = new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS);
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
}