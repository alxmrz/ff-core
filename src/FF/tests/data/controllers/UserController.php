<?php

namespace FF\tests\data\controllers;

use FF\BaseController;
use FF\http\RequestInterface;
use FF\http\ResponseInterface;
use FF\tests\data\TestService;

class UserController extends BaseController
{
    public function actionGetByName(RequestInterface $request, ResponseInterface $response, TestService $service): void
    {
        $response->withBody($service->doStuff());
    }
}