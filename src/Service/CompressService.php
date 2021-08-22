<?php

namespace Xatenev\Zippify\Service;

use ZipArchive;

class CompressService
{

    public function __construct(private string $outDirectory)
    {
    }

    public function zip(string $directory)
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

        $zip->close();

        return $fullyQualifiedName;
    }
}