<?php declare(strict_types=1);

namespace Xatenev\Zippify\Service;

use Phar;
use PharData;
use Psr\Log\LoggerInterface;
use Xatenev\Zippify\Enum\UploadTypeEnum;
use Xatenev\Zippify\Model\UploadMappingModel;
use ZipArchive;

class ArchiveService
{

    public function __construct(private LoggerInterface $logger, private string $outDirectory)
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

    public function bz2(PharData $archive): PharData
    {
        $archive->setMetadata(['archiveFileName' => $archive->getMetadata()['archiveFileName'] . '.bz2']);
        return $archive->compress(Phar::BZ2);
    }

    public function remove(ZipArchive|PharData $archive): bool
    {
        if ($archive instanceof ZipArchive) {
            return unlink($this->outDirectory . $this->name($archive));
        } else {
            return unlink($this->outDirectory . $archive->getMetadata('archiveFileName'));
        }
    }

    public function tar(UploadMappingModel $uploadMapping): PharData
    {
        $uploadMapping->setType(UploadTypeEnum::TAR);

        $filename = $uploadMapping->getToken() . '.tar';
        $fullyQualifiedName = $this->outDirectory . $filename;

        $tar = new PharData($fullyQualifiedName);
        $tar->setMetadata(['archiveFileName' => $filename]);

        foreach ($uploadMapping->getItems() as $uploadItem) {
            $tar->addFile($uploadMapping->getFilepath() . $uploadItem->getKey(), $uploadItem->getValue());
        }

        return $tar;
    }

    public function zip(UploadMappingModel $uploadMapping): ZipArchive
    {
        $uploadMapping->setType(UploadTypeEnum::ZIP);

        $zip = new ZipArchive();
        $filename = $uploadMapping->getToken() . '.zip';
        $fullyQualifiedName = $this->outDirectory . $filename;

        if ($zip->open($fullyQualifiedName, ZipArchive::CREATE) !== TRUE) {
            // @todo: Logging
            exit("cannot open <$fullyQualifiedName>\n");
        }

        foreach ($uploadMapping->getItems() as $uploadItem) {
            $zip->addFile($uploadMapping->getFilepath() . $uploadItem->getKey(), $uploadItem->getValue());
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