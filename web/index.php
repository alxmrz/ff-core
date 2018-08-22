<?php

use core\container\PHPDIContainer;

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/dbconf.php';
$container = new PHPDIContainer();
(new core\Application($container, $config))->run();
