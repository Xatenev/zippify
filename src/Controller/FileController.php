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

        $settings = $request->getParsedBody();
        $password = $settings['password'];
        $tar = json_decode($settings['tar']);
        $gz = json_decode($settings['gz']);
        $share = json_decode($settings['share']);

        $uploadedFiles = $request->getUploadedFiles();
        $directory = $uploadService->moveUploadedFiles($uploadedFiles['file']);

        $zip = $compressService->zip($directory);

        if(strlen($password) > 0) {
            $compressService->password($zip, $password);
        }

        $response->getBody()->write(OUT_URL .  $compressService->name($zip));

        $compressService->close($zip);

        return $response;
    })->setName('createFile');
});