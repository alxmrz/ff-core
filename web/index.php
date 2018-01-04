<?php
require __DIR__ . '/../myautoloader.php';

$config = require __DIR__ . '/../config/dbconf.php';

(new core\Application($config))->run();
