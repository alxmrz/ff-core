<?php

/**
 * Use this template for index.php to start project.
 * Specify correct param controllerNamespace for Application to load controllers (for mode=default)
 * Application in micro mode does not need controllerNamespace
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


/*********** MICRO MODE **************/

$definitions = [
    MonologLogger::class => function () {
        return new MonologLogger(new Logger('app_name_index'));
    },
    View::class => function () {
        return new View(new TemplateEngine(__DIR__ . '/../view'));
    }
];

$container = new PHPDIContainer($definitions);

$app = (new Application($container, ['mode' => 'micro']));

$app->get('/', function () {
    return 'Hello from main route';
});

$app->run();