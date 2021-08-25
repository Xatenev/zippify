<?php declare(strict_types=1);

namespace Zippify\Routes;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

$app->get('/', function (Request $request, Response $response, $args) {
    $renderer = new PhpRenderer(TEMPLATE_DIR);

    return $renderer->render(
        $response,
        'index.php',
        array_fill_keys(['tar', 'gz', 'password', 'share', 'settings'], false)
    );
});

$app->get('/{route}', function (Request $request, Response $response, $args) {
    $renderer = new PhpRenderer(TEMPLATE_DIR);

    $route = $args['route'];

    $view = [];
    $view['tar'] = str_contains($route, 'tar');
    $view['gz'] = str_contains($route, 'tar') && str_contains($route, 'gz');
    $view['password'] = str_contains($route, 'password');
    $view['share'] = str_contains($route, 'share');
    $view['settings'] = in_array(true, $view);

    return $renderer->render(
        $response,
        'index.php',
        $view
    );
});