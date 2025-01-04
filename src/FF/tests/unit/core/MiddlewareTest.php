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
    /**
     * @runInSeparateProcess
     * @return void
     */
    public function testMiddleWareForOneRoute(): void
    {
        $_SERVER['REQUEST_URI'] = '/order';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        /**
         * @var LoggerInterface $logger
         */
        $logger = $this->createStub(LoggerInterface::class);


        $app = new Application(
            new PHPDIContainer(),
            new Router(new FileManagerFake()),
            $logger
            
        );

        $actual = '';
        $mw = static function() use (&$actual):void {
            $actual = 'Hello World';
        };

        $app->get('/order', static function (RequestInterface $request, ResponseInterface $response):void {
            $response->withBody('<p>Order route</p>');
        })->add($mw);

        $this->expectOutputString('<p>Order route</p>');

        $app->run();

        $this->assertEquals('Hello World', $actual);
    }
}
