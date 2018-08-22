<?php

use core\container\PHPDIContainer;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/consts.php';

$config = require __DIR__ . '/../config/config.php';
$definitions = require __DIR__ . '/../config/definitions.php';
$container = new PHPDIContainer($definitions);

(new core\Application($container, $config))->run();
