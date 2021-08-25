<?php declare(strict_types=1);

namespace Xatenev\Zippify\Service;

use Phar;
use PharData;
use ZipArchive;

class ArchiveService
{

    public function __construct(private string $outDirectory)
    {
    }

    public function password(ZipArchive $zip, string $password)
    {
        $zip->setPassword($password);

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $zip->setEncryptionIndex($i, ZipArchive::EM_AES_256);
        }
    }

    public function gz(PharData $archive): PharData
    {
        $archive->setMetadata(['archiveFileName' => $archive->getMetadata()['archiveFileName'] . '.gz']);
        return $archive->compress(Phar::GZ);
    }

    public function remove(ZipArchive|PharData $archive): bool
    {
        if ($archive instanceof ZipArchive) {
            return unlink($this->outDirectory . $this->name($archive));
        } else {
            return unlink($this->outDirectory . $archive->getMetadata('archiveFileName'));
        }
    }

    public function tar(string $directory): PharData
    {
        $filename = bin2hex(random_bytes(GENERATED_FILES_TOKEN_LENGTH)) . '.tar';
        $fullyQualifiedName = $this->outDirectory . $filename;

        $tar = new PharData($fullyQualifiedName);
        $tar->setMetadata(['archiveFileName' => $filename]);

        $dir = new \RecursiveDirectoryIterator($directory);
        $iterator = new \RecursiveIteratorIterator($dir);

        foreach ($iterator as $file) {
            $fName = $file->getFilename();
            if ($fName !== '.' && $fName !== '..') {
                $tar->addFile($file->getPathname(), $fName);
            }
        }

        return $tar;
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

        $zip->close();
        $zip->open($fullyQualifiedName);

        return $zip;
    }

    public function name(ZipArchive|PharData $archive)
    {
        if ($archive instanceof ZipArchive) {
            return substr($archive->filename, strrpos($archive->filename, DS) + 1);
        } else {
            return $archive->getMetadata()['archiveFileName'];
        }
    }

    public function close(ZipArchive|PharData $zip)
    {
        if ($zip instanceof ZipArchive) {
            $zip->close();
        } else {
            $zip->delMetadata();
        }
    }
}