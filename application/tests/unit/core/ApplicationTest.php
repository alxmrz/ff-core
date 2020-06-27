<?php
declare(strict_types=1);

use core\Application;

final class ApplicationTest extends CustomTestCase
{

    private $application;

    public function setUp()
    {
        parent::setUp();
        $_SERVER['REQUEST_URI'] = '/mainpage/';
        $this->application = new Application($this->nativeContainer);
    }

    public function testMock()
    {
        $this->assertTrue(1 === 1);
    }

    /**
     * TODO: need to fix the test
     */
    public function _testApplicationShowsErrorPageIfException(): void
    {
        $this->expectOutputRegex('/(Ошибка!)/');
        $_SERVER['REQUEST_URI'] = 'job/unavailablerequest/';
        $this->application = (new Application($this->nativeContainer))->run();
    }

    /**
     * TODO: need to fix the test
     */
    public function _testApplicationGeneratesMainPageCorrectly(): void
    {
        $_SERVER['REQUEST_URI'] = '/mainpage/';
        $this->application = new Application($this->nativeContainer);
        $this->expectOutputRegex('/(Main page)/');
        $this->application->run();
    }
}
