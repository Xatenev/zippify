<?php declare(strict_types=1);

namespace Xatenev\Zippify\Command;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Cleans all unnecessary files in upload and data folders.
 *
 * Example:
 * `composer clean`
 */
class CleanCommand
{
    const WHITELIST = [
        'gitkeep'
    ];

    public static function clean()
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

        // Remove unnecessary files in /data/meta folder
        $keep = [];
        $remove = [];
        $directoryIterator = new RecursiveDirectoryIterator(META_DIR, FilesystemIterator::SKIP_DOTS);
        $recursiveIterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($recursiveIterator as $file) {
            $fullPath = $file->getPath() . DS . $file->getFilename();
            if ($file->isFile() && !in_array($file->getExtension(), self::WHITELIST, true)) {
                $meta = json_decode(file_get_contents($fullPath), true);
                if ($meta['expiration'] < time()) {
                    $remove[] = $meta['token'];
                    unlink($fullPath);
                } else {
                    $keep[] = $meta['token'];
                }
            }
        }

        // Remove unnecessary files in /out folder
        $directoryIterator = new RecursiveDirectoryIterator(OUT_DIR, FilesystemIterator::SKIP_DOTS);
        $recursiveIterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($recursiveIterator as $file) {
            $fullPath = $file->getPath() . DS . $file->getFilename();
            $token = basename($file->getFilename(), '.' . pathinfo($file->getFilename(), PATHINFO_EXTENSION));

            if (
                $file->isFile()
                && !in_array($file->getExtension(), self::WHITELIST, true)
                && (in_array($token, $remove)
                    || (!in_array($token, $remove) && !in_array($token, $keep)))
            ) {
                if (!in_array($file->getExtension(), self::WHITELIST, true)) {
                    unlink($fullPath);
                }
            }
        }
    }
}