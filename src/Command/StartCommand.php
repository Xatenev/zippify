<?php declare(strict_types=1);

namespace Xatenev\Zippify\Command;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

/**
 * Starts the application
 *
 * Example:
 * `composer start -- 9999`
 */
class StartCommand
{
    public static function start(Event $event)
    {
        require_once __DIR__ . '/../../app/const.php';

        $port = $event->getArguments()[0];
        exec('php -S localhost:' . $port . ' -t ' . PUBLIC_DIR);
    }
}