<?php

use core\container\PHPDIContainer;

require __DIR__ . '/vendor/autoload.php';

echo (new core\ConsoleApplication($argv))->run();
