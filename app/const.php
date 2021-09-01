<?php declare(strict_types=1);

define('APPLICATION_NAME', 'Zippify');
define('DS', DIRECTORY_SEPARATOR);

define('BASE_URL', php_sapi_name() === 'cli' ? '' : (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/');
define('OUT_URL', BASE_URL . 'out' . '/');

define('ROOT_DIR', realpath(__DIR__ . DS . '..') . DS);
define('SRC_DIR', realpath(ROOT_DIR . 'src') . DS);
define('TEMPLATE_DIR', realpath(SRC_DIR . 'Template') . DS);
define('CONTROLLER_DIR', realpath(SRC_DIR . 'Controller') . DS);

define('PUBLIC_DIR', realpath(ROOT_DIR . 'public') . DS);
define('VENDOR_DIR', realpath(ROOT_DIR . 'vendor') . DS);
define('DATA_DIR', realpath(ROOT_DIR . 'data') . DS);
define('PHPMUSSEL_DIR', realpath(DATA_DIR . 'phpmussel') . DS);
define('META_DIR', realpath(DATA_DIR . 'meta') . DS);
define('UPLOAD_DIR', realpath(DATA_DIR . 'upload') . DS);
define('OUT_DIR', realpath(PUBLIC_DIR . 'out') . DS);
define('LOGS_DIR', realpath(ROOT_DIR . 'logs') . DS);

define('GENERATED_FILES_TOKEN_LENGTH', 16);
define('QUARANTINE_KEY_LENGTH', 16);
