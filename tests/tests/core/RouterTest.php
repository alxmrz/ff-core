<?php

declare(strict_types = 1);

use core\Router;
use core\Controller;
use core\HttpDemultiplexer;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{

  private $router;

  public function setUp(): void
  {
    $_SERVER['REQUEST_URI'] = 'job/mainpage/';
  }

  public function testGettingArrayWithRoute(): void
  {
    $this->router = new Router();
    $uri = "mainpage/getList";
    $expectedData = [
      'controller' => 'MainpageController',
      'action' => 'getListAction',
    ];
    $this->assertEqual($expectedData, $this->router->parseUri($uri));
  }

}
