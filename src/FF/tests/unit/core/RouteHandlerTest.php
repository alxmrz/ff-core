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

    public function testInvoke_WithArgs()
    {
        $value = '';
        $routeHandler = new RouteHandler(static function (RequestInterface $request, ResponseInterface $response, string $name) use (&$value):void  {
            $value = $name;
        });

        $routeHandler(new Request(), new Response(), ['John']);

        $this->assertSame('John', $value);
    }

    public function testInvokeWithMiddleWare(): void
    {
        $routeHandler = new RouteHandler(static function (RequestInterface $request, ResponseInterface $response) {
            
        });

        $modify = '';
        $mw = static function (RequestInterface $request, ResponseInterface $response) use (&$modify) {
            $modify = "Hello, World";
        };

        $routeHandler->add($mw);

        $routeHandler(new Request(), new Response);

        $this->assertSame("Hello, World", $modify);
    }

    public function testInvokeWithMiddleWare_DoNotCallHandlerIfMiddlewareReturnFalse(): void
    {
        $result = '';
        $routeHandler = new RouteHandler(static function (RequestInterface $request, ResponseInterface $response)  use (&$result) {
            $result = 'changed';
        });

        $mw = static function (RequestInterface $request, ResponseInterface $response): bool {
            return false;
        };

        $routeHandler->add($mw);

        $routeHandler(new Request(), new Response);

        $this->assertEquals('',$result);
    }

    public function testInvokeWithMiddleWare_NeedPassRequestAndArgs(): void
    {
        $routeHandler = new RouteHandler(static function (RequestInterface $request, ResponseInterface $response):void {
        });

        $result = '';
        $mw = static function (RequestInterface $request, ResponseInterface $response, string $name) use (&$result) : bool {
            $result = $name;
            
            return true;
        };

        $routeHandler->add($mw);

        $routeHandler(new Request(), new Response, ['Eva']);

        $this->assertEquals('Eva',$result);
    }
}