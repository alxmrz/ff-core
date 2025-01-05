<?php

namespace tests\unit\core;

use FF\Application;
use FF\tests\unit\CommonTestCase;
use FF\container\PHPDIContainer;
use FF\tests\stubs\FileManagerFake;
use FF\router\Router;
use Psr\Log\LoggerInterface;
use FF\http\RequestInterface;
use FF\http\ResponseInterface;

class MiddlewareTest extends CommonTestCase
{
    private Application $app;

    public function setUp(): void
    {
        /**
         * @var LoggerInterface $logger
         */
        $logger = $this->createStub(LoggerInterface::class);

        $this->app = new Application(
            new PHPDIContainer(),
            new Router(new FileManagerFake()),
            $logger
        );
    }

    /**
     * @runInSeparateProcess
     * @return void
     */
    public function testMiddleWareForOneRoute(): void
    {
        $actual = '';
        $mw = static function() use (&$actual):void {
            $actual = 'Hello World';
        };

        $this->app->get('/order', static function (RequestInterface $request, ResponseInterface $response):void {
            $response->withBody('<p>Order route</p>');
        })->add($mw);

        $this->expectOutputString('<p>Order route</p>');

      $this->runRequest('/order', 'GET');

        $this->assertEquals('Hello World', $actual);
    }

    /**
     * @runInSeparateProcess
     * @return void
     */
    public function testMiddleWareForAllRoutes(): void
    {
        $actual = '';
        $this->app->add(static function(RequestInterface $request, ResponseInterface $response) use (&$actual):void {
            $actual .= 'Hello' . $request->context()['request'] ?? '';
        })->add(static function(RequestInterface $request, ResponseInterface $response) use (&$actual):void {
            $actual .= 'World' . $request->context()['request'] ?? '';
        });

        $this->app->get('/', static function (RequestInterface $request, ResponseInterface $response):void {
            $response->withBody('<p>Main route</p>');
        });
        $this->app->get('/order', static function (RequestInterface $request, ResponseInterface $response):void {
            $response->withBody('<p>Order route</p>');
        });

        $this->expectOutputString('<p>Main route</p><p>Order route</p>');

        $this->runRequest('/', 'GET');
        $this->assertEquals('Hello/World/', $actual);

        $actual = '';

        $this->runRequest('/order', 'GET');
        $this->assertEquals('Hello/orderWorld/order', $actual);
    }

        /**
     * @runInSeparateProcess
     * @return void
     */
    public function testMiddleWareOfAllRoutesCanStopRoutesProcessing(): void
    {
        $this->app->add(static function(RequestInterface $request, ResponseInterface $response):bool {
            return false;
        });

        $actual = 'expected';
        $this->app->get('/', static function (RequestInterface $request, ResponseInterface $response) use (&$actual):void {
            $actual = 'actual';
            $response->withBody('<p>Main route</p>');
        });
        
        $this->expectOutputString('');

        $this->runRequest('/', 'GET');

        $this->assertEquals('expected', $actual);
    }

    private function runRequest(string $path, string $method)
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_SERVER['REQUEST_URI'] = $path;

        $this->app->run();
    }
}
