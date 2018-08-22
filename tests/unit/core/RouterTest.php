<?php
declare(strict_types=1);

use core\router\Router;

final class RouterTest extends CustomTestCase
{
    /**
     * @var Router
     */
    private $router;

    public function setUp(): void
    {
        parent::setUp();
        $this->router = new Router();
    }

    public function testGettingArrayWithRoute(): void
    {

        $uri = "/mainpage/getList";
        $expectedData = [
            'controller' => 'MainpageController',
            'action' => 'actionGetList',
        ];
        $this->router->parseUri($uri);
        $this->assertEquals($expectedData['controller'], $this->router->getController());
        $this->assertEquals($expectedData['action'], $this->router->getAction());
    }

    public function testTwrowingErrorWhenRequestIs404()
    {
        $this->expectException(core\exceptions\UnavailableRequestException::class);
        $uri = 'job/unavailablerequest/';
        $this->router->parseUri($uri);
    }

}
