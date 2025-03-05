<?php

declare(strict_types=1);

namespace FF\tests\unit\core;

use FF\http\Request;
use FF\http\Response;
use FF\http\RequestInterface;
use FF\http\ResponseInterface;
use FF\router\RouteHandler;
use FF\tests\unit\CommonTestCase;

final class RouteHandlerTest extends CommonTestCase
{
    public function testInvoke(): void
    {
        $value = '';

        $routeHandler = new RouteHandler(
            static function (RequestInterface $request, ResponseInterface $response) use (&$value): void {
                $value = 'modified';
            }
        );

        $routeHandler(new Request(), new Response());

        $this->assertSame('modified', $value);
    }

    public function testInvoke_WithArgs(): void
    {
        $value = '';
        $routeHandler = new RouteHandler(
            static function (RequestInterface $request, ResponseInterface $response, string $name) use (&$value): void {
                $value = $name;
            }
        );

        $routeHandler(new Request(), new Response(), ['John']);

        $this->assertSame('John', $value);
    }

    public function testInvokeWithMiddleWare(): void
    {
        $routeHandler = new RouteHandler(
            static function (RequestInterface $request, ResponseInterface $response): void {
            }
        );

        $modify = '';
        $mw = static function (RequestInterface $request, ResponseInterface $response) use (&$modify): void {
            $modify = "Hello, World";
        };

        $routeHandler->add($mw);

        $routeHandler(new Request(), new Response);

        $this->assertSame("Hello, World", $modify);
    }

    public function testInvokeWithMiddleWare_DoNotCallHandlerIfMiddlewareReturnFalse(): void
    {
        $result = '';
        $routeHandler = new RouteHandler(
            static function (RequestInterface $request, ResponseInterface $response) use (&$result): void {
                $result = 'changed';
            }
        );

        $mw = (static fn(RequestInterface $request, ResponseInterface $response): bool => false);

        $routeHandler->add($mw);

        $routeHandler(new Request(), new Response);

        $this->assertEquals('', $result);
    }

    public function testInvokeWithMiddleWare_NeedPassRequestAndArgs(): void
    {
        $routeHandler = new RouteHandler(
            static function (RequestInterface $request, ResponseInterface $response): void {
            }
        );

        $result = '';
        $mw = static function (RequestInterface $request, ResponseInterface $response, string $name) use (&$result
        ): bool {
            $result = $name;

            return true;
        };

        $routeHandler->add($mw);

        $routeHandler(new Request(), new Response, ['Eva']);

        $this->assertEquals('Eva', $result);
    }
}
