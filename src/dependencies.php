<?php

namespace Xatenev\Zippify;

use DI\Container;
use GuzzleHttp\Client;
use Xatenev\Zippify\Service\CompressService;
use Xatenev\Zippify\Service\UploadService;

$container->set('uploadService', function (Container $c) {
    return new UploadService(UPLOAD_DIR);
});
$container->set('compressService', function (Container $c) {
    return new CompressService(OUT_DIR);
});
$container->set('httpClient', function (Container $c) {
    return new Client();
});