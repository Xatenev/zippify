<?php

namespace Zippify\Routes;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

$app->get('/', function (Request $request, Response $response, $args) {
    $renderer = new PhpRenderer(TEMPLATE_DIR);
    return $renderer->render($response, 'index.php', $args);
});