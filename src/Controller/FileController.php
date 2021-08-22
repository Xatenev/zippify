<?php

namespace Xatenev\Zippify\Controller;

use Slim\Routing\RouteCollectorProxy;
use Xatenev\Zippify\Service\CompressService;
use Xatenev\Zippify\Service\ScannerService;
use Xatenev\Zippify\Service\UploadService;

$app->group('/file', function (RouteCollectorProxy $group) {
    $group->post('', function ($request, $response, array $args) {
        /** @var UploadService $uploadService */
        $uploadService = $this->get('uploadService');
        /** @var CompressService $compressService */
        $compressService = $this->get('compressService');
        /** @var ScannerService $scannerService */
        $scannerService = $this->get('scannerService');

        $uploadedFiles = $request->getUploadedFiles();
        $directory = $uploadService->moveUploadedFiles($uploadedFiles['file']);

        $zip = $compressService->zip($directory);

        $response->getBody()->write(OUT_URL .  substr($zip, strrpos($zip, '/') + 1));
        return $response;
    })->setName('createFile');
});