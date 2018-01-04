<?php

declare(strict_types = 1);

use core\Router;
use core\Controller;
use core\HttpDemultiplexer;
use core\exceptions\UnavailableRequestException;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{

  private $router;

  public function setUp()
  {
    
  }

  public function testRouterHaveControllerAndHttpDemultiplexer()
  {
    $_SERVER['REQUEST_URI'] = 'job/mainpage/';
    $this->router = new Router(array());
    $this->assertTrue($this->router->getController() instanceof Controller);
    $this->assertTrue($this->router->getHttpDemultiplexer() instanceof HttpDemultiplexer);
  }

  public function testRouterGeneratesMainPageCorrectly()
  {
    $_SERVER['REQUEST_URI'] = 'job/mainpage/';
    $this->router = new Router(array());
    $this->expectOutputRegex('/(Главная страница)/');
    $this->router->startApplication('');
  }
  public function testThrowingExceptionIfNoAvailableRequestReceived()
  { 
    $this->expectException(UnavailableRequestException::class);
    $_SERVER['REQUEST_URI'] = 'job/unavailablerequest/';
    $this->router = new Router(array());
  }
}
