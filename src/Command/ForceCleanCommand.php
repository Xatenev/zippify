<?php declare(strict_types=1);

namespace Xatenev\Zippify\Command;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Cleans all upload and data folders.
 *
 * Example:
 * `composer force-clean`
 */
class ForceCleanCommand
{
    const WHITELIST = [
        'gitkeep'
    ];

    public static function forceClean()
    {
        require_once __DIR__ . '/../../app/const.php';

        // Remove /data/upload folder
        $directoryIterator = new RecursiveDirectoryIterator(UPLOAD_DIR, FilesystemIterator::SKIP_DOTS);
        $recursiveIterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($recursiveIterator as $file) {
            $fullPath = $file->getPath() . DS . $file->getFilename();

            if ($file->isDir()) {
                rmdir($fullPath);
            } else {
                if (!in_array($file->getExtension(), self::WHITELIST, true)) {
                    unlink($fullPath);
                }
            }
        }

        // Remove /data/meta folder
        $directoryIterator = new RecursiveDirectoryIterator(META_DIR, FilesystemIterator::SKIP_DOTS);
        $recursiveIterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($recursiveIterator as $file) {
            $fullPath = $file->getPath() . DS . $file->getFilename();

            if ($file->isDir()) {
                rmdir($fullPath);
            } else {
                if (!in_array($file->getExtension(), self::WHITELIST, true)) {
                    unlink($fullPath);
                }
            }
        }

        // Remove /out folder
        $directoryIterator = new RecursiveDirectoryIterator(OUT_DIR, FilesystemIterator::SKIP_DOTS);
        $recursiveIterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($recursiveIterator as $file) {
            $fullPath = $file->getPath() . DS . $file->getFilename();

            if ($file->isDir()) {
                rmdir($fullPath);
            } else {
                if (!in_array($file->getExtension(), self::WHITELIST, true)) {
                    unlink($fullPath);
                }
            }
        }
    }
}