<?php declare(strict_types=1);

namespace Xatenev\Zippify;

define('DS', DIRECTORY_SEPARATOR);
define('PS', '.');

define('BASE_URL', php_sapi_name() === 'cli' ? '' : (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/');
define('OUT_URL', BASE_URL . 'out' . '/');

define('ROOT_DIR', realpath(__DIR__ . DS . '..') . DS);
define('VENDOR_DIR', ROOT_DIR . 'vendor' . DS);
define('SRC_DIR', __DIR__ . DS);
define('PHPMUSSEL_DIR', ROOT_DIR . 'phpmussel' . DS);
define('PUBLIC_DIR', realpath(__DIR__ . DS . '..' . DS . 'public') . DS);

define('OUT_DIR', PUBLIC_DIR . 'out' . DS);
define('UPLOAD_DIR', realpath(ROOT_DIR . 'upload') . DS);
define('TEMPLATE_DIR', realpath(SRC_DIR . 'Template') . DS);
define('CONTROLLER_DIR', realpath(SRC_DIR . 'Controller') . DS);

define('GENERATED_FILES_TOKEN_LENGTH', 16);
