<?php

declare(strict_types=1);

namespace FF\tests\unit\core;

use FF\Application;
use FF\router\Router;
use Psr\Log\LoggerInterface;
use FF\http\RequestInterface;
use FF\http\ResponseInterface;
use FF\tests\data\TestService;
use FF\container\PHPDIContainer;
use FF\tests\unit\CommonTestCase;
use FF\tests\stubs\FileManagerFake;
use FF\exceptions\MethodAlreadyRegistered;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

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

        $app = new Application(new PHPDIContainer(), new Router(new FileManagerFake()), $this->createStub(LoggerInterface::class));
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

        $app = new Application(new PHPDIContainer(), new Router(new FileManagerFake()), $this->createStub(LoggerInterface::class));
        $app->post('/order', function (RequestInterface $request, ResponseInterface $response) {
            $response->withBody('Order route from post');
        });

        $this->expectOutputString('Order route from post');

        $app->run();
    }

    public function testConstruct(): void
    {
        $application = Application::construct(['viewPath' => 'viewPath', 'definitions' => []]);

        $this->assertInstanceOf(Application::class, $application);
    }

    /**
     * @runInSeparateProcess
     * @return void
     * @throws ContainerExceptionInterface
     * @throws MethodAlreadyRegistered
     * @throws NotFoundExceptionInterface
     */
    public function testDependencyInjectionIntoHandler(): void
    {
        $_SERVER['REQUEST_URI'] = '/order';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $app = new Application(new PHPDIContainer(), new Router(new FileManagerFake()), $this->createStub(LoggerInterface::class));
        
        $app->get('/order', function (RequestInterface $request, ResponseInterface $response, TestService $service) {
            $response->withBody($service->doStuff());
        });

        $this->expectOutputString('some-test-value-test-service');

        $app->run();
    }
}
