<?php

declare(strict_types = 1);

use core\Application;
use core\Controller;
use core\HttpDemultiplexer;
use core\exceptions\UnavailableRequestException;
use PHPUnit\Framework\TestCase;

final class ApplicationTest extends TestCase
{

  private $application;

  public function setUp()
  {
    
  }

  public function testRouterHaveControllerAndHttpDemultiplexer()
  {
    $_SERVER['REQUEST_URI'] = 'job/mainpage/';
    $this->application = new Application(array());
    $this->assertTrue($this->application->getController() instanceof Controller);
    $this->assertTrue($this->application->getHttpDemultiplexer() instanceof HttpDemultiplexer);
  }

  public function testRouterGeneratesMainPageCorrectly()
  {
    $_SERVER['REQUEST_URI'] = 'job/mainpage/';
    $this->application = new Application(array());
    $this->expectOutputRegex('/(Главная страница)/');
    $this->application->run('');
  }
  public function testThrowingExceptionIfNoAvailableRequestReceived()
  { 
    $this->expectException(UnavailableRequestException::class);
    $_SERVER['REQUEST_URI'] = 'job/unavailablerequest/';
    $this->application = new Application(array());
  }
}
