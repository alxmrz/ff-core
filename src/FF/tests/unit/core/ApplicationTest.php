<?php
declare(strict_types=1);

use FF\Application;
use FF\exceptions\MethodAlreadyRegistered;
use FF\ExitCode;
use FF\request\Request;
use FF\router\Router;
use FF\tests\unit\CommonTestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

final class ApplicationTest extends CommonTestCase
{
    public function testRunGetRoutesViaAnonymousFunction(): void
    {
        $_SERVER['REQUEST_URI'] = '/order';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $router = $this->createStub(Request::class);
        $router->method('server')->willReturnOnConsecutiveCalls($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        $app = new Application($this->createContainerStub(request: $router), ['mode' => 'micro']);
        $app->get('/order', function () {
            return 'Order route';
        });

        $this->expectOutputString('Order route');
        $app->run();
    }

    public function testControllerNamespaceMustBeSpecifiedWhenAppModeIsDefault(): void
    {
        $app = new Application($this->createContainerStub(), ['mode' => 'micro']);
        $this->assertEquals(ExitCode::ERROR, $app->run());

        $this->expectOutputRegex('/Params controllerNamespace is not specified in app config/');
        $app = new Application($this->createContainerStub(), ['mode' => 'default']);
        $this->assertEquals(ExitCode::ERROR, $app->run());
    }

    public function testErrorOnTryingSpecifyMethodWithTheSameName(): void
    {
        $app = new Application($this->createContainerStub(), ['mode' => 'micro']);

        $this->expectException(MethodAlreadyRegistered::class);
        $this->expectExceptionMessage('Method GET /order already registered!');
        $app->get('/order', function () {
            return 'Order route';
        });
        $app->get('/order', function () {
            return 'Order route';
        });
    }

    public function testRegisterPostMethod(): void
    {
        $_SERVER['REQUEST_URI'] = '/order';
        $_SERVER['REQUEST_METHOD'] = 'POST';

        $router = $this->createStub(Request::class);
        $router->method('server')->willReturnOnConsecutiveCalls($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        $app = new Application($this->createContainerStub(request: $router), ['mode' => 'micro']);
        $app->post('/order', function () {
            return 'Order route from post';
        });

        $this->expectOutputString('Order route from post');
        $app->run();
    }

    private function createContainerStub(Request $request = null): ContainerInterface
    {
        $containerStub = $this->createStub(ContainerInterface::class);
        $containerStub->method('get')->willReturnOnConsecutiveCalls(
            $this->createStub(Router::class),
            $request ?? $this->createStub(Request::class),
            $this->createStub(LoggerInterface::class)
        );

        return $containerStub;
    }
}
