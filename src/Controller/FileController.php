<?php declare(strict_types=1);

namespace Xatenev\Zippify\Controller;

use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;
use Xatenev\Zippify\Model\ViewSettings;
use Xatenev\Zippify\Service\ArchiveService;
use Xatenev\Zippify\Service\UploadService;

return function (App $app) {
    $app->group('/file', function (RouteCollectorProxy $group) {
        $group->post('', function (Request $request, Response $response, array $args) {
            /** @var UploadService $uploadService */
            $uploadService = $this->get('uploadService');
            /** @var ArchiveService $archiveService */
            $archiveService = $this->get('archiveService');

            $settings = ViewSettings::createFromArray($request->getParsedBody()['settings']);
            $uploadedFiles = $request->getUploadedFiles();

            $directory = $uploadService->moveUploadedFiles($uploadedFiles['file']);

            if ($settings->hasVirus() && $uploadService->virusScan($directory)) {
                $uploadService->remove($directory);
                return $response->withStatus(400, 'Malicious data detected');
            }

            if ($settings->hasTar()) {
                $archive = $archiveService->tar($directory);

                if ($settings->hasGz()) {
                    $archive = $archiveService->gz($archive);
                }

                if($settings->hasBz2()) {
                    $archive = $archiveService->bz2($archive);
                }
            } else {
                $archive = $archiveService->zip($directory);

                if (strlen($settings->getPasswordInput()) > 0) {
                    $archiveService->password($archive, $settings->getPasswordInput());
                }
            }

            $response->getBody()->write(OUT_URL . $archiveService->name($archive));

            $uploadService->remove($directory);
            $archiveService->close($archive);
            return $response;
        })->setName('createFile');
    });
};