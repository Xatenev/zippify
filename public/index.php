<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

// Register routes

require_once __DIR__ . '/../src/const.php';
require_once SRC_DIR . 'dependencies.php';
require_once SRC_DIR . 'controller.php';

$app->run();