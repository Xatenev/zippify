<?php declare(strict_types=1);

namespace Xatenev\Zippify\Controller;

use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;
use Xatenev\Zippify\Service\ArchiveService;
use Xatenev\Zippify\Service\UploadService;

return function (App $app) {
    $app->group('/file', function (RouteCollectorProxy $group) {
        $group->post('', function (Request $request, Response $response, array $args) {
            /** @var UploadService $uploadService */
            $uploadService = $this->get('uploadService');
            /** @var ArchiveService $archiveService */
            $archiveService = $this->get('archiveService');

            $settings = $request->getParsedBody();
            $password = $settings['password'];
            $tar = json_decode($settings['tar']);
            $gz = json_decode($settings['gz']);
            $bz2 = json_decode($settings['bz2']);
            $share = json_decode($settings['share']);
            $virus = json_decode('true');

            $uploadedFiles = $request->getUploadedFiles();
            $directory = $uploadService->moveUploadedFiles($uploadedFiles['file']);

            if ($virus && $uploadService->virusScan($directory)) {
                $uploadService->remove($directory);
                return $response->withStatus(400, 'Malicious data detected');
            }

            if ($tar) {
                $archive = $archiveService->tar($directory);

                if ($gz) {
                    $archive = $archiveService->gz($archive);
                }

                if($bz2) {
                    $archive = $archiveService->bz2($archive);
                }
            } else {
                $archive = $archiveService->zip($directory);

                if (strlen($password) > 0) {
                    $archiveService->password($archive, $password);
                }
            }

            $response->getBody()->write(OUT_URL . $archiveService->name($archive));

            $uploadService->remove($directory);
            $archiveService->close($archive);
            return $response;
        })->setName('createFile');
    });
};