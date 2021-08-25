<?php declare(strict_types=1);

namespace Xatenev\Zippify\Controller;

use Slim\Routing\RouteCollectorProxy;
use Xatenev\Zippify\Service\ArchiveService;
use Xatenev\Zippify\Service\ScannerService;
use Xatenev\Zippify\Service\UploadService;

$app->group('/file', function (RouteCollectorProxy $group) {
    $group->post('', function ($request, $response, array $args) {
        /** @var UploadService $uploadService */
        $uploadService = $this->get('uploadService');
        /** @var ArchiveService $archiveService */
        $archiveService = $this->get('archiveService');

        $settings = $request->getParsedBody();
        $password = $settings['password'];
        $tar = json_decode($settings['tar']);
        $gz = json_decode($settings['gz']);
        $share = json_decode($settings['share']);

        $uploadedFiles = $request->getUploadedFiles();
        $directory = $uploadService->moveUploadedFiles($uploadedFiles['file']);

        $archive = null;

        if($tar) {
            $archive = $archiveService->tar($directory);

            if($gz) {
                $archive = $archiveService->gz($archive);
            }
        } else {
            $archive = $archiveService->zip($directory);

            if(strlen($password) > 0) {
                $archiveService->password($archive, $password);
            }
        }

        $response->getBody()->write(OUT_URL .  $archiveService->name($archive));

        $uploadService->remove($directory);

        $archiveService->close($archive);
        return $response;
    })->setName('createFile');
});