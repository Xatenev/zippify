<?php

use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
$app = AppFactory::createFromContainer($container);

require_once __DIR__ . '/../app/const.php';

$dependencies = require_once __DIR__ . '/../app/dependencies.php';
$dependencies($container);

$controller = require_once __DIR__ . '/../app/controller.php';
$controller($app);

$app->run();