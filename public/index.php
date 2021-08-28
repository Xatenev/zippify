<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
$app = AppFactory::createFromContainer($container);

require_once __DIR__ . '/../app/const.php';

$dependencies = require_once __DIR__ . '/../app/dependencies.php';
$dependencies($container);

$controller = require_once __DIR__ . '/../app/controller.php';
$controller($app);

$app->run();