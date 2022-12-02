<?php
declare(strict_types=1);

namespace app\tests\unit\core;

use FF\Application;
use FF\container\PHPDIContainer;
use FF\exceptions\MethodAlreadyRegistered;
use FF\http\RequestInterface;
use FF\http\ResponseInterface;
use FF\router\Router;
use FF\tests\unit\CommonTestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;

final class ApplicationTest extends CommonTestCase
{
    /**
     * @runInSeparateProcess
     * @return void
     * @throws MethodAlreadyRegistered
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testRunGetRoutesViaAnonymousFunction(): void
    {
        $_SERVER['REQUEST_URI'] = '/order';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $app = new Application(new PHPDIContainer(), new Router(), $this->createStub(LoggerInterface::class));
        $app->get('/order', function (RequestInterface $request, ResponseInterface $response) {
            $response->withBody('<p>Order route</p>');
        });

        $this->expectOutputString('<p>Order route</p>');

        $app->run();
    }


    /**
     * @runInSeparateProcess
     * @return void
     * @throws ContainerExceptionInterface
     * @throws MethodAlreadyRegistered
     * @throws NotFoundExceptionInterface
     */
    public function testRegisterPostMethod(): void
    {
        $_SERVER['REQUEST_URI'] = '/order';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $app = new Application(new PHPDIContainer(), new Router(), $this->createStub(LoggerInterface::class));
        $app->post('/order', function (RequestInterface $request, ResponseInterface $response) {
            $response->withBody('Order route from post');
        });

        $this->expectOutputString('Order route from post');

        $app->run();
    }
}
