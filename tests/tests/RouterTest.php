<?php

declare(strict_types = 1);

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

  public function testRouterHaveControllerAndHttpDemultiplexer()
  {
    $this->assertTrue($this->router->getController() instanceof Controller);
    $this->assertTrue($this->router->getHttpDemultiplexer() instanceof HttpDemultiplexer);
  }

  public function testRouterGeneratesPageCorrectly()
  {
    ob_start();
    $this->router->startApplication();
    $return = ob_get_contents();
    ob_end_clean();
    $this->assertContains('Главная страница', $return);
  }

}
