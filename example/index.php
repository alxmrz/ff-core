<?php

/**
 * Use this template for index.php to start project.
 * Application expects you to register handlers for web path via $app->get or $app->post
 * Alternatively you can create controller with action to work with
 * For example web path GET /order/create can be defined as (Slim way):
 * $app->get('/order/create', function(RequestInterface $request, ResponseInterface $response) {
 *     $response->setBody("Hello from order create request");
 *     }
 *  );
 * or as a controller (Yii2 way):
 *   ./src/controller/OrderController::createAction(RequestInterface $request, ResponseInterface $response)
 */

use FF\Application;
use FF\container\PHPDIContainer;
use FF\http\Request;
use FF\http\Response;
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

$app = (new Application($container, ['controllerNamespace' => 'app\controller\\']));
$app->get('/', function (Request $request, Response $response) {
    $response->setBody("Hello from main route");
});
$app->get('/order', function($request, Response $response) {
    $response->setBody("Hello from order request");
});

$app->run();