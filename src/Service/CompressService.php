<?php

namespace Xatenev\Zippify\Service;

use ZipArchive;

class CompressService
{

    public function __construct(private string $outDirectory)
    {
    }

    public function password(ZipArchive $zip, string $password) {
        $zip->setPassword($password);

        for($i = 0; $i < $zip->numFiles; $i++) {
            $zip->setEncryptionIndex($i, ZipArchive::EM_AES_256);
        }
    }

    public function zip(string $directory): ZipArchive
    {
        $zip = new ZipArchive();
        $filename = bin2hex(random_bytes(GENERATED_FILES_TOKEN_LENGTH)) . '.zip';
        $fullyQualifiedName = $this->outDirectory . $filename;

        if ($zip->open($fullyQualifiedName, ZipArchive::CREATE) !== TRUE) {
            // @todo: Logging
            exit("cannot open <$fullyQualifiedName>\n");
        }

        $dir = new \RecursiveDirectoryIterator($directory);
        $iterator = new \RecursiveIteratorIterator($dir);

        foreach ($iterator as $file) {
            $fName = $file->getFilename();
            if ($fName !== '.' && $fName !== '..') {
                $zip->addFile($file->getPathname(), $fName);
            }
        }

        return $zip;
    }

    public function name(ZipArchive $zip) {
        return substr($zip->filename, strrpos($zip->filename, '/') + 1);
    }

    public function path(ZipArchive $zip) {
        return $zip->filename;
    }

    public function close(ZipArchive $zip) {
        $zip->close();
    }
}