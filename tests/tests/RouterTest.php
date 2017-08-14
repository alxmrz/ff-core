<?php
declare(strict_types=1);

use core\Router;
use core\Controller;
use core\HttpDemultiplexer;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    public $router;
    public function setUp()
    {
        $_SERVER['REQUEST_URI'] = 'http://job/mainpage/';
        $this->router = new Router(array());
    }
    public function testRouterInitialization()
    {
        $this->assertTrue($this->router->getController() instanceof Controller);
        $this->assertTrue($this->router->getHttpDemultiplexer() instanceof HttpDemultiplexer);
    }
    public function testRouterGeneratesPage()
    {
      ob_start();
      $this->router->startApplication();
      $buffer = ob_get_contents();
      ob_clean();
      $str = substr('Главная страница',$buffer);
      $this->assertEqual('Главная страница',$str);
    }

}
