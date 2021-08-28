<?php declare(strict_types=1);

namespace Xatenev\Zippify;

use DI\Container;
use GuzzleHttp\Client;
use phpMussel\Core\Loader;
use phpMussel\Core\Scanner;
use Xatenev\Zippify\Service\ArchiveService;
use Xatenev\Zippify\Service\UploadService;

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
    return new UploadService(UPLOAD_DIR, $c->get('virusScanner'));
});
$container->set('archiveService', function (Container $c) {
    return new ArchiveService(OUT_DIR);
});
$container->set('httpClient', function (Container $c) {
    return new Client();
});