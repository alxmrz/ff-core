<?php

use FF\Application;
use FF\http\Request;
use FF\http\Response;

include_once '../../vendor/autoload.php';

$app = Application::construct(['appName' => 'ff-demo-app']);

$app->get('/', function (Request $request, Response $response) {
    $response->setBody("Hello from main route");
});
$app->post('/order', function(Request $request, Response $response) {
    $response->setBody("Hello from order post request");
});

$app->run();