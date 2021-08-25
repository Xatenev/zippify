<?php declare(strict_types=1);

namespace Xatenev\Zippify;

use DI\Container;
use GuzzleHttp\Client;
use Xatenev\Zippify\Service\ArchiveService;
use Xatenev\Zippify\Service\UploadService;

$container->set('uploadService', function (Container $c) {
    return new UploadService(UPLOAD_DIR);
});
$container->set('archiveService', function (Container $c) {
    return new ArchiveService(OUT_DIR);
});
$container->set('httpClient', function (Container $c) {
    return new Client();
});