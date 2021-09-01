<?php declare(strict_types=1);

namespace Xatenev\Zippify\Command;

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
        'clamav.cedb',
        'clamav.db',
        'clamav.fdb',
        'clamav.hdb',
        'clamav.htdb',
        'clamav.mdb',
        'clamav.ndb',
        'clamav_elf.db',
        'clamav_elf_regex.db',
        'clamav_email.db',
        'clamav_email_regex.db',
        'clamav_exe.db',
        'clamav_exe_regex.db',
        'clamav_graphics.db',
        'clamav_graphics_regex.db',
        'clamav_java.db',
        'clamav_java_regex.db',
        'clamav_macho.db',
        'clamav_macho_regex.db',
        'clamav_ole.db',
        'clamav_ole_regex.db',
        'clamav_pdf.db',
        'clamav_pdf_regex.db',
        'clamav_regex.db',
        'clamav_regex.db',
        'clamav_regex.htdb',
        'clamav_regex.ndb',
        'clamav_swf.db',
        'clamav_swf_regex.db',
    ];

    const SIGNATURES_URL = 'https://github.com/phpMussel/Signatures/blob/master/clamav/%s?raw=true';

    public static function updateSignatures()
    {
        require_once __DIR__ . '/../../app/const.php';
        $client = new Client();

        foreach (self::SIGNATURES as $signature) {
            $url = sprintf(self::SIGNATURES_URL, $signature . '.gz?raw=true');
            $filename = sprintf(PHPMUSSEL_DIR . 'signatures' . DS . '%s', $signature . '.gz');

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