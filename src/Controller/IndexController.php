<?php declare(strict_types=1);

namespace Zippify\Routes;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Views\PhpRenderer;
use Xatenev\Zippify\Model\ViewSettingsModel;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, $args) {
        $renderer = new PhpRenderer(TEMPLATE_DIR, ['settings' => new ViewSettingsModel()]);

        return $renderer->render($response, 'index.php');
    });

    $app->get('/{route}', function (Request $request, Response $response, $args) {
        $renderer = new PhpRenderer(TEMPLATE_DIR, ['settings' => ViewSettingsModel::createFromRoute($args['route'])]);

        return $renderer->render($response, 'index.php');
    });
};