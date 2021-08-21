<?php

namespace Xatenev\Zippify\Controller;

use Slim\Routing\RouteCollectorProxy;
use Xatenev\Zippify\Service\CompressService;
use Xatenev\Zippify\Service\UploadService;

$app->group('/file', function (RouteCollectorProxy $group) {
    $group->post('', function ($request, $response, array $args) {
        /** @var UploadService $uploadService */
        $uploadService = $this->get('uploadService');
        /** @var CompressService $compressService */
        $compressService = $this->get('compressService');

        $uploadedFiles = $request->getUploadedFiles();
        $directory = $uploadService->moveUploadedFiles($uploadedFiles['file']);

        $zip = $compressService->zip($directory);
        $response->getBody()->write(OUT_URL . $zip);
        return $response;
    })->setName('createFile');
});