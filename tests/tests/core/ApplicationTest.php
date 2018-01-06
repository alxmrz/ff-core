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

  public function setUp(): void
  {
    $_SERVER['REQUEST_URI'] = 'job/mainpage/';
  }

  public function testApplicationHasControllerAndHttpDemultiplexerAfterConstuct(): void
  {
    $this->application = new Application();
    $this->assertTrue($this->application->getController() instanceof Controller);
    $this->assertTrue($this->application->getHttpDemultiplexer() instanceof HttpDemultiplexer);
  }
  
  public function testApplicationAnalizesRequestUriCorrectly(): void
  {
    $this->application = new Application();
    $this->assertEquals('mainpage', $this->application->getPageToRender());
    $_SERVER['REQUEST_URI'] = 'job/skills/';
    $this->application = new Application();
    $this->assertEquals('skills', $this->application->getPageToRender());
  }
  
  public function testApplicationGeneratesRightController(): void
  {
    $this->application = new Application();
    $this->assertInstanceOf(\controller\mainpageController::class, $this->application->getController());
    $_SERVER['REQUEST_URI'] = 'job/skills/';
    $this->application = new Application();
    $this->assertInstanceOf(\controller\skillsController::class, $this->application->getController());
  }
  
  public function testApplicationShowsErrorPageIfException(): void 
  {
    $this->expectOutputRegex('/(Ошибка!)/');
    $_SERVER['REQUEST_URI'] = 'job/unavailablerequest/';
    $this->application = new Application();
  }
  
  public function testApplicationGeneratesMainPageCorrectly(): void
  {
    $_SERVER['REQUEST_URI'] = 'job/mainpage/';
    $this->application = new Application();
    $this->expectOutputRegex('/(Главная страница)/');
    $this->application->run();
  }

}
