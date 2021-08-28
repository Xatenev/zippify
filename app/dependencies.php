<?php declare(strict_types=1);

use DI\Container;
use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use phpMussel\Core\Loader;
use phpMussel\Core\Scanner;
use Xatenev\Zippify\Service\ArchiveService;
use Xatenev\Zippify\Service\UploadService;

return function (Container $container) {
    $container->set('logger', function (Container $c) {
        $logger = new Logger(mb_strtolower(APPLICATION_NAME));
        $logger->pushHandler(new StreamHandler(LOGS_DIR . mb_strtolower(APPLICATION_NAME) . '.log', Logger::DEBUG));

        return $logger;
    });
    $container->set('httpClient', function (Container $c) {
        return new Client();
    });
    $container->set('virusScanner', function (Container $c) {
        $loader = new Loader(
            PHPMUSSEL_DIR . 'phpmussel.yml',
            PHPMUSSEL_DIR . 'cache',
            PHPMUSSEL_DIR . 'quarantine',
            PHPMUSSEL_DIR . 'signatures',
            VENDOR_DIR
        );

        return new Scanner($loader);
    });
    $container->set('uploadService', function (Container $c) {
        return new UploadService($c->get('logger'), UPLOAD_DIR, $c->get('virusScanner'));
    });
    $container->set('archiveService', function (Container $c) {
        return new ArchiveService($c->get('logger'), OUT_DIR);
    });
};