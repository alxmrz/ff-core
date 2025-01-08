<?php

declare(strict_types=1);

namespace FF\tests\unit\core;

use FF\http\Request;
use FF\http\Response;
use FF\router\Router;
use FF\router\RouteHandler;
use FF\tests\unit\CommonTestCase;
use FF\exceptions\MethodAlreadyRegistered;
use FF\exceptions\UnavailableRequestException;

final class RouterTest extends CommonTestCase
{
    private Router $router;

    public function setUp(): void
    {
        parent::setUp();
        $this->router = new Router( ['controllerNamespace' => 'app\controller\\']);
    }

    public function testParseRequest_NoHandlersSet(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/mainpage/getList';

        $router = new Router();

        [$handler, $args, $controllerName, $action] = $router->parseRequest($this->createRequest());

        $this->assertNull($handler);
        $this->assertEmpty($args);
        $this->assertEmpty($controllerName);
        $this->assertEmpty($action);
    }

    public function testParseRequest_GettingArrayWithRoute(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/mainpage/getList';

        [$handler, $args, $controllerName, $action] = $this->router->parseRequest($this->createRequest());

        $this->assertNull($handler);
        $this->assertEmpty($args);
        $this->assertEquals('MainpageController', $controllerName);
        $this->assertEquals('actionGetList', $action);
    }

    /**
     * @throws MethodAlreadyRegistered
     */
    public function testErrorOnTryingSpecifyMethodWithTheSameName(): void
    {
        $this->expectException(MethodAlreadyRegistered::class);
        $this->expectExceptionMessage('Method GET /order already registered!');
        $this->router->get('/order', function () {
            return 'Order route';
        });
        $this->router->get('/order', function () {
            return 'Order route';
        });
    }

    /**
     * @dataProvider dpTestParsingVariablesInUri
     *
     * @return void
     * @throws MethodAlreadyRegistered
     * @throws UnavailableRequestException
     */
    public function testParsingVariablesInUri(string $uri, string $route, array $expectedArgs)
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = $uri;
        $func = function () {
            return 'Order route get by id';
        };
        $this->router->get($route, $func);
        [$handler, $args, $controllerName, $action] = $this->router->parseRequest($this->createRequest());

        $this->assertEquals(new RouteHandler($func), $handler);
        $this->assertNull($controllerName);
        $this->assertNull($action);
        $this->assertEquals($expectedArgs, $args);
    }

    private function dpTestParsingVariablesInUri(): array
    {
        return [
            ['uri' => '/', 'route' => '/', 'expectedArgs' => []],
            ["uri" => '/order/5', 'route' => '/order/{id}', 'expectedArgs' => ['id' => '5']],
            ["uri" => '/user/5/order/2', 'route' => '/user/{id}/order/{number}', 'expectedArgs' => ['id' => '5', 'number' => '2']],
        ];
    }

    public function testDifferentRoutesWithTheSameStructure(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/order/5';

        $value = '';

        $this->router->get('/order/{id}', function () use (&$value) {
            $value = 'order';
        });
        
        $this->router->get('/shop/{id}', function () use (&$value) {
            $value = 'shop';
        });

        [$handler, $args, $controllerName, $action] = $this->router->parseRequest($this->createRequest());

        $this->assertNotNull($handler);

        $handler($this->createRequest(), new Response());

        $this->assertEquals('order', $value);
    }

    public function testDifferentRoutesWithTheSameStructureButReverOrder(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/order/5';

        $value = '';

        $this->router->get('/shop/{id}', function () use (&$value) {
            $value = 'shop';
        });

        $this->router->get('/order/{id}', function () use (&$value) {
            $value = 'order';
        });

        [$handler, $args, $controllerName, $action] = $this->router->parseRequest($this->createRequest());

        $this->assertNotNull($handler);

        $handler($this->createRequest(), new Response());

        $this->assertEquals('order', $value);
    }


    public function testRouteWithGetParamsParsedCorrectly(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/order?name=test';

        $value = '';

        $this->router->get('/order', function () use (&$value) {
            $value = 'order';
        });

        [$handler, $args, $controllerName, $action] = $this->router->parseRequest($this->createRequest());

        $this->assertNotNull($handler);

        $handler($this->createRequest(), new Response());

        $this->assertEquals('order', $value);
    }

    private function createRequest(): Request
    {
        return new Request();
    }
}
