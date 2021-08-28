<?php declare(strict_types=1);

namespace Xatenev\Zippify\Command;

use Composer\Installer\PackageEvent;
use Composer\Script\Event;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;

/**
 * Updates the virus signatures required by phpmussel to check files for known malicious data
 *
 * Example:
 * `composer update-signatures`
 */
class UpdateSignaturesCommand
{
    /**
     * See possible values at https://github.com/phpMussel/Signatures/tree/master/clamav
     * Signatures have to be registered in phpmussel.yml aswell
     */
    const SIGNATURES = [
        'clamav'
    ];

    const SIGNATURES_URL = 'https://github.com/phpMussel/Signatures/blob/master/clamav/%s?raw=true';

    public static function updateSignatures(Event $event)
    {
        require_once __DIR__ . '/../const.php';
        $client = new Client();

        foreach(self::SIGNATURES as $signature) {
            $url = sprintf(self::SIGNATURES_URL, $signature . '.db.gz?raw=true');
            $filename = sprintf(ROOT_DIR . 'phpmussel' . DS . 'signatures' . DS . '%s', $signature . '.db.gz');

            $resource = Utils::tryFopen($filename, 'wb');
            $stream = Utils::streamFor($resource);
            $client->request('GET', $url, ['sink' => $stream]);
            fclose($resource);

            $file = gzopen($filename, 'rb');
            $outFile = fopen(str_replace('.gz', '', $filename), 'wb');

            while (!gzeof($file)) {
                fwrite($outFile, gzread($file, 4096));
            }

            fclose($outFile);
            gzclose($file);
            unlink($filename);
        }
    }
}