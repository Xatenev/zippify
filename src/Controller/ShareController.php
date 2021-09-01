<?php declare(strict_types=1);

namespace Xatenev\Zippify\Controller;

use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;
use Slim\Views\PhpRenderer;
use Xatenev\Zippify\Service\UploadService;

return function (App $app) {
    $app->group('/share/', function (RouteCollectorProxy $group) {
        $group->get('{token}', function (Request $request, Response $response, array $args) {

            /** @var UploadService $uploadService */
            $uploadService = $this->get('uploadService');
            $token = $args['token'];
            $meta = $uploadService->getMetaByToken($token);

            $renderer = new PhpRenderer(TEMPLATE_DIR, [
                'token' => $meta['items'],
                'type' => $meta['type'],
                'expiration' => $meta['expiration'],
                'size' => $meta['size'],
                'count' => $meta['count'],
                'url' => OUT_URL . $token . '.' . $meta['type']
            ]);

            if($meta['expiration']->getTimestamp() < time()) {
                return $response->withStatus(301)->withHeader('Location', '/');
            }

            return $renderer->render($response, 'share.php');
        })->setName('shareFile');
    });
};