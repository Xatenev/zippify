<?php declare(strict_types=1);

use Slim\App;

return function (App $app) {
    /* Include all controller files in this directory recursively */
    $dir = new \RecursiveDirectoryIterator(CONTROLLER_DIR);
    $iterator = new \RecursiveIteratorIterator($dir);

    foreach ($iterator as $file) {
        $fName = $file->getFilename();
        if (preg_match('%\.php$%', $fName)) {
            $controller = require_once $file->getPathname();
            $controller($app);
        }
    }
};