<?php

declare(strict_types=1);

use FF\Application;
use FF\http\RequestInterface;
use FF\http\ResponseInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$app = Application::construct(['appName' => 'ff-demo-app']);

$app->get('/', function (RequestInterface $request, ResponseInterface $response) {
    $response->withBody("Hello from main route");
});

// Note that $id and other uri variables will be strings, cast operation is on you
$app->get('/order/{id}', function (RequestInterface $request, ResponseInterface $response, string $id) {
    $response->withBody("Get order with id = {$id}");
})->add(function(RequestInterface $request, ResponseInterface $response, string $id):bool {
    
    if ($id === '4') {
        $response->withBody('Bad request');
        return false;
    }
    
    return true;
});

$app->post('/order', function(RequestInterface $request, ResponseInterface $response) {
    $response->withJsonBody(["message" => "Hello from order post request"]);
});

$app->run();