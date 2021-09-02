<?php declare(strict_types=1);

namespace Xatenev\Zippify\Controller;

use RuntimeException;
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;
use Xatenev\Zippify\Model\ViewSettingsModel;
use Xatenev\Zippify\Service\ArchiveService;
use Xatenev\Zippify\Service\UploadService;

return function (App $app) {
    $app->group('/file', function (RouteCollectorProxy $group) {
        $group->post('', function (Request $request, Response $response) {
            /** @var UploadService $uploadService */
            $uploadService = $this->get('uploadService');
            /** @var ArchiveService $archiveService */
            $archiveService = $this->get('archiveService');

            if(!$uploadService->check($request->getUploadedFiles()['file'])) {
                return $response->withStatus(400, 'Bad file input detected');
            }

            $settings = ViewSettingsModel::createFromArray($request->getParsedBody()['settings']);
            $upload = $uploadService->upload($request->getUploadedFiles()['file']);

            if ($settings->hasVirus() && !$uploadService->virusScan($upload->getFilepath())) {
                $uploadService->remove($upload->getFilepath());
                return $response->withStatus(400, 'Malicious data detected');
            }

            if ($settings->hasTar()) {
                $archive = $archiveService->tar($upload);

                if ($settings->hasGz()) {
                    $archive = $archiveService->gz($upload, $archive);
                }

                if ($settings->hasBz2()) {
                    $archive = $archiveService->bz2($upload, $archive);
                }
            } else {
                $archive = $archiveService->zip($upload);

                if (strlen($settings->getPasswordInput()) > 0) {
                    $archiveService->password($archive, $settings->getPasswordInput());
                }
            }

            if ($settings->hasShare()) {
                $uploadService->generateMeta($upload);
                $response->getBody()->write(BASE_URL . 'share' . '/' . $upload->getToken());
            } else {
                $response->getBody()->write(OUT_URL . $archiveService->name($archive));
            }

            $uploadService->remove($upload->getFilepath());
            $archiveService->close($archive);
            return $response;
        })->setName('createFile');
    });
};