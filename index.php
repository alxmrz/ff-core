<?php

require 'myautoloader.php';

$config = require 'config/dbconf.php';
$router = new core\Router($config);
$router->startApplication();






