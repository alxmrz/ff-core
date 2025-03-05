<?php

declare(strict_types=1);

namespace FF\tests\unit\core;

use FF\Application;
use FF\container\PHPDIContainer;
use FF\exceptions\MethodAlreadyRegistered;
use FF\http\RequestInterface;
use FF\http\ResponseInterface;
use FF\router\Router;
use FF\tests\data\TestService;
use FF\tests\unit\CommonTestCase;
use PHPUnit\Framework\MockObject\Stub;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;

final class ApplicationTest extends CommonTestCase
{
    /**
     * @runInSeparateProcess
     * @throws MethodAlreadyRegistered
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testRunGetRoutesViaAnonymousFunction(): void
    {
        $_SERVER['REQUEST_URI'] = '/order';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $app = $this->createApplication();
        
        $app->get('/order', function (RequestInterface $request, ResponseInterface $response): void {
            $response->withBody('<p>Order route</p>');
        });

        $this->expectOutputString('<p>Order route</p>');

        $app->run();
    }

    /**
     * @runInSeparateProcess
     * @throws ContainerExceptionInterface
     * @throws MethodAlreadyRegistered
     * @throws NotFoundExceptionInterface
     */
    public function testRegisterPostMethod(): void
    {
        $_SERVER['REQUEST_URI'] = '/order';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $app = $this->createApplication();
        
        $app->post('/order', function (RequestInterface $request, ResponseInterface $response): void {
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
     * @throws ContainerExceptionInterface
     * @throws MethodAlreadyRegistered
     * @throws NotFoundExceptionInterface
     */
    public function testDependencyInjectionIntoHandler(): void
    {
        $_SERVER['REQUEST_URI'] = '/order';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $app = $this->createApplication();

        $app->get('/order', function (RequestInterface $request, ResponseInterface $response, TestService $service): void {
            $response->withBody($service->doStuff());
        });

        $this->expectOutputString('some-test-value-test-service');

        $app->run();
    }

    /**
     * @runInSeparateProcess
     * @throws ContainerExceptionInterface
     * @throws MethodAlreadyRegistered
     * @throws NotFoundExceptionInterface
     */
    public function testDependencyInjectionIntoHandlerWithRouteArgs(): void
    {
        $_SERVER['REQUEST_URI'] = '/order/5';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $app = $this->createApplication();

        $app->get('/order/{id}', function (RequestInterface $request, ResponseInterface $response, string $id, TestService $service): void {
            $response->withBody($service->doStuff() . ' ' . $id);
        });

        $this->expectOutputString('some-test-value-test-service 5');

        $app->run();
    }

    /**
     * @runInSeparateProcess
     * @throws ContainerExceptionInterface
     * @throws MethodAlreadyRegistered
     * @throws NotFoundExceptionInterface
     */
    public function testDependencyInjectionIntoControllersAction(): void
    {
        $_SERVER['REQUEST_URI'] = '/user/get-by-name';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $config = [
            'controllerNamespace' => '\FF\tests\data\controllers\\',
        ];

        $this->expectOutputString('some-test-value-test-service');

        $this->createApplication($config)->run();
    }

    /**
     * @runInSeparateProcess
     * @throws ContainerExceptionInterface
     * @throws MethodAlreadyRegistered
     * @throws NotFoundExceptionInterface
     */
    public function testException_WhenHandlerAndControllerDoesNotExist(): void
    {
        $_SERVER['REQUEST_URI'] = '/unknown/get-by-name';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $config = [
            'controllerNamespace' => '\FF\tests\data\controllers\\',
        ];

        $this->expectOutputString('Not found a handler or a controller for request: GET /unknown/get-by-name');

        $this->createApplication($config)->run();
    }

        /**
     * @runInSeparateProcess
     * @throws ContainerExceptionInterface
     * @throws MethodAlreadyRegistered
     * @throws NotFoundExceptionInterface
     */
    public function testException_WhenCotrollerActionDoesNotExist(): void
    {
        $_SERVER['REQUEST_URI'] = '/user/unknown';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $config = [
            'controllerNamespace' => '\FF\tests\data\controllers\\',
        ];

        $this->expectOutputString('Action actionUnknown not found in controller \FF\tests\data\controllers\UserController');

        $this->createApplication($config)->run();
    }

    private function createApplication(array $config = []): Application
    {
        /** @var LoggerInterface|Stub $logger */
        $logger = $this->createStub(LoggerInterface::class);

        return new Application(
            new PHPDIContainer(),
            new Router($config),
            $logger,
            $config
        );
    }
}
