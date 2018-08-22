<?php

declare(strict_types=1);

use core\Application;
use core\container\PHPDIContainer;
use core\request\Request;
use PHPUnit\Framework\TestCase;

final class ApplicationTest extends TestCase
{

    private $application;

    public function setUp(): void
    {
        $_SERVER['REQUEST_URI'] = '/mainpage/';
        $this->container = new PHPDIContainer();
        $this->application = new Application($this->container);
    }

    public function testApplicationHasControllerAndHttpDemultiplexerAfterConstuct(): void
    {
        $this->assertTrue($this->application->router->getController() === 'MainpageController');
        $this->assertTrue($this->application->getRequest() instanceof Request);
    }

    public function testApplicationAnalizesRequestUriCorrectly(): void
    {
        $this->assertEquals('MainpageController', $this->application->router->getController());
    }

    public function testApplicationGeneratesRightController(): void
    {
        $this->assertInstanceOf(\controller\MainpageController::class, $this->application->getController());
    }

    /**
     * TODO: need to fix the test
     */
    public function _testApplicationShowsErrorPageIfException(): void
    {
        $this->expectOutputRegex('/(Ошибка!)/');
        $_SERVER['REQUEST_URI'] = 'job/unavailablerequest/';
        $this->application = new Application($this->container);
    }

    public function testApplicationGeneratesMainPageCorrectly(): void
    {
        $_SERVER['REQUEST_URI'] = '/mainpage/';
        $this->application = new Application($this->container);
        $this->expectOutputRegex('/(Main page)/');
        $this->application->run();
    }
}
