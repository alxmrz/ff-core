<?php

declare(strict_types = 1);

use core\Application;
use core\Controller;
use core\exceptions\UnavailableRequestException;
use core\request\Request;
use PHPUnit\Framework\TestCase;

final class ApplicationTest extends TestCase
{

  private $application;

  public function setUp(): void
  {
    $_SERVER['REQUEST_URI'] = '/mainpage/';
  }

  public function testApplicationHasControllerAndHttpDemultiplexerAfterConstuct(): void
  {
    $this->application = new Application();
    $this->assertTrue($this->application->router->getController() === 'MainpageController');
    $this->assertTrue($this->application->getHttpDemultiplexer() instanceof Request);
  }
  
  public function testApplicationAnalizesRequestUriCorrectly(): void
  {
    $this->application = new Application();
    $this->assertEquals('MainpageController', $this->application->router->getController());
  }
  
  public function testApplicationGeneratesRightController(): void
  {
    $this->application = new Application();
    $this->assertInstanceOf(\controller\MainpageController::class, $this->application->getController());
  }
 
  public function testApplicationShowsErrorPageIfException(): void 
  {
    $this->expectOutputRegex('/(Ошибка!)/');
    $_SERVER['REQUEST_URI'] = 'job/unavailablerequest/';
    $this->application = new Application();
  }
  
  public function testApplicationGeneratesMainPageCorrectly(): void
  {
    $_SERVER['REQUEST_URI'] = '/mainpage/';
    $this->application = new Application();
    $this->expectOutputRegex('/(Главная страница)/');
    $this->application->run();
  }

}
