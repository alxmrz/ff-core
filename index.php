<?php

require 'myautoloader.php';

$config = require 'config/dbconf.php';

(new core\Router($config))->startApplication();







