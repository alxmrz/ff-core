<?php

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/dbconf.php';

(new core\Application($config))->run();
