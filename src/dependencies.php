<?php

namespace Xatenev\Zippify;
use DI\Container;
use Psr\Container\ContainerInterface;
use Xatenev\Zippify\Service\CompressService;
use Xatenev\Zippify\Service\UploadService;

$container->set('uploadService', function (Container $c) {
    return new UploadService(UPLOAD_DIR);
});
$container->set('compressService', function (Container $c) {
    return new CompressService(OUT_DIR);
});