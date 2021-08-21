<?php

namespace Xatenev\Zippify;

/* Include all controller files in this directory recursively */
$dir = new \RecursiveDirectoryIterator(CONTROLLER_DIR);
$iterator = new \RecursiveIteratorIterator($dir);

foreach ($iterator as $file) {
    $fName = $file->getFilename();
    if (preg_match('%\.php$%', $fName)) {
        require_once $file->getPathname();
    }
}
