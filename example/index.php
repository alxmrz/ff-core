<?php

/**
 * Use this template for index.php to start project.
 * Specify correct param controllerNamespace for Application to load controllers
 */

use FF\Application;
use FF\container\PHPDIContainer;
use FF\logger\MonologLogger;
use FF\view\TemplateEngine;
use FF\view\View;
use Monolog\Logger;

include_once '../../vendor/autoload.php';

$definitions = [
    MonologLogger::class => function () {
        return new MonologLogger(new Logger('app_name_index'));
    },
    View::class => function () {
        return new View(new TemplateEngine(__DIR__ . '/../view'));
    }
];

$container = new PHPDIContainer($definitions);

(new Application($container, ['controllerNamespace' => 'app\controller\\']))->run();