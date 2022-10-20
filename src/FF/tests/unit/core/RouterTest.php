<?php
declare(strict_types=1);

use FF\exceptions\MethodAlreadyRegistered;
use FF\http\Request;
use FF\router\Router;
use FF\tests\unit\CommonTestCase;

final class RouterTest extends CommonTestCase
{
    /**
     * @var Router
     */
    private Router $router;

    public function setUp(): void
    {
        parent::setUp();
        $this->router = new Router(['controllerNamespace' => 'app\controller\\']);
    }

    public function testGettingArrayWithRoute(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/mainpage/getList';

        [$controllerName, $action] = $this->router->parseRequest($this->createRequest());

        $this->assertEquals('MainpageController', $controllerName);
        $this->assertEquals( 'actionGetList', $action);
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

    public function testControllerNamespaceMustBeSpecifiedWhenAppModeIsDefault(): void
    {
        $router = new Router();

        $this->expectExceptionMessage('Params controllerNamespace is not specified in app config');
        $router->parseRequest($this->createRequest());
    }

    public function _testThrowErrorWhenRequestIs404()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'job/unavailablerequest/';

        $this->expectException(FF\exceptions\UnavailableRequestException::class);
        $this->router->parseRequest($this->createRequest());
    }

    private function createRequest(): Request
    {
        return new Request();
    }
}
