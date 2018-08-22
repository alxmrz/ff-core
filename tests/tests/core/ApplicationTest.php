<?php

declare(strict_types=1);

use core\Application;
use core\container\PHPDIContainer;
use PHPUnit\Framework\TestCase;

final class ApplicationTest extends TestCase
{

    private $application;
    private $container;

    public function setUp(): void
    {
        $_SERVER['REQUEST_URI'] = '/mainpage/';
        $definitions = require __DIR__ . '/../../../config/definitions.php';
        $this->container = new PHPDIContainer($definitions);
        $this->application = new Application($this->container);
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

    /**
     * TODO: need to fix the test
     */
    public function _testApplicationGeneratesMainPageCorrectly(): void
    {
        $_SERVER['REQUEST_URI'] = '/mainpage/';
        $this->application = new Application($this->container);
        $this->expectOutputRegex('/(Main page)/');
        $this->application->run();
    }
}
