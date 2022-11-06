<?php

declare(strict_types=1);

use FF\Application;
use FF\http\RequestInterface;
use FF\http\ResponseInterface;

include_once '../../vendor/autoload.php';

$app = Application::construct(['appName' => 'ff-demo-app']);

$app->get('/', function (RequestInterface $request, ResponseInterface $response) {
    $response->withBody("Hello from main route");
});
// Note that $id and other uri variables will be strings, cast operation is on you
$app->get('/order/{id}', function (RequestInterface $request, ResponseInterface $response, string $id) {
    $response->withBody("Get order with id = ${id}");
});
$app->post('/order', function(RequestInterface $request, ResponseInterface $response) {
    $response->withJsonBody(["message" => "Hello from order post request"]);
});

$app->run();