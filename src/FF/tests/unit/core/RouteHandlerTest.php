<?php

namespace FF\tests\unit\core;

use FF\http\Request;
use FF\http\Response;
use FF\http\RequestInterface;
use FF\http\ResponseInterface;
use FF\router\RouteHandler;
use FF\tests\unit\CommonTestCase;

final class RouteHandlerTest extends CommonTestCase
{
    public function testInvoke()
    {
        $value = '';

        $routeHandler = new RouteHandler(static function (RequestInterface $request, ResponseInterface $response) use (&$value):void  {
            $value = 'modified';
        });

        $routeHandler(new Request(), new Response());

        $this->assertSame('modified', $value);
    }

    public function testInvokeWithMiddleWare(): void
    {
        $routeHandler = new RouteHandler(static function (RequestInterface $request, ResponseInterface $response) {
            
        });

        $modify = '';
        $mw = static function () use (&$modify) {
            $modify = "Hello, World";
        };

        $routeHandler->add($mw);

        $routeHandler(new Request(), new Response);

        $this->assertSame("Hello, World", $modify);
    }
}