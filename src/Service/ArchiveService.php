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

    /**
     * ArchiveService constructor.
     *
     * @param LoggerInterface $logger
     * @param string $outDirectory
     */
    public function __construct(private LoggerInterface $logger, private string $outDirectory)
    {
    }

    /**
     * Set $password for $zip.
     *
     * @param ZipArchive $zip
     * @param string $password
     */
    public function password(ZipArchive $zip, string $password): void
    {
        $zip->setPassword($password);

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $zip->setEncryptionIndex($i, ZipArchive::EM_AES_256);
        }
    }

    /**
     * Compress given $archive with gz.
     *
     * @param UploadMappingModel $uploadMapping
     * @param PharData $archive
     * @return PharData
     */
    public function gz(UploadMappingModel $uploadMapping, PharData $archive): PharData
    {
        $uploadMapping->setType(UploadTypeEnum::TARGZ);

        $archive->setMetadata(['archiveFileName' => $archive->getMetadata()['archiveFileName'] . '.gz']);
        return $archive->compress(Phar::GZ);
    }

    /**
     * Compress given $archive with bz2.
     *
     * @param UploadMappingModel $uploadMapping
     * @param PharData $archive
     * @return PharData
     */
    public function bz2(UploadMappingModel $uploadMapping, PharData $archive): PharData
    {
        $uploadMapping->setType(UploadTypeEnum::TARBZ2);

        $archive->setMetadata(['archiveFileName' => $archive->getMetadata()['archiveFileName'] . '.bz2']);
        return $archive->compress(Phar::BZ2);
    }

    /**
     * Remove given $archive
     *
     * @param ZipArchive|PharData $archive
     * @return bool
     */
    public function remove(ZipArchive|PharData $archive): bool
    {
        if ($archive instanceof ZipArchive) {
            return unlink($this->outDirectory . $this->name($archive));
        } else {
            return unlink($this->outDirectory . $archive->getMetadata('archiveFileName'));
        }
    }

    /**
     * Get name by $archive.
     *
     * @param ZipArchive|PharData $archive
     * @return string
     */
    public function name(ZipArchive|PharData $archive): string
    {
        if ($archive instanceof ZipArchive) {
            return substr($archive->filename, strrpos($archive->filename, DS) + 1);
        } else {
            return $archive->getMetadata()['archiveFileName'];
        }
    }

    /**
     * Generate tar.
     *
     * @param UploadMappingModel $uploadMapping
     * @return PharData
     */
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

    /**
     * Generate zip.
     *
     * @param UploadMappingModel $uploadMapping
     * @return ZipArchive
     */
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

    /**
     * Close $archive.
     *
     * @param ZipArchive|PharData $archive
     */
    public function close(ZipArchive|PharData $archive): void
    {
        if ($archive instanceof ZipArchive) {
            $archive->close();
        } else {
            $archive->delMetadata();
        }
    }
}