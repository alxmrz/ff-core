<?php
declare(strict_types=1);

use core\View;
use PHPUnit\Framework\TestCase;

final class ViewTest extends TestCase
{
    public $view;
    public function setUp()
    {
        $_SERVER['REQUEST_URI'] = 'http://job/mainpage/';
        $this->view = new View();
    }
    public function testViewInitialization()
    {
        $arrayMustBe = [
            'css' => [
                'class.css',
                'general.css',
                'id.css'
            ],
            'js' => [
                'clock.js',
                'cookie.js',
                'main.js'
            ]
        ];
        $this->assertEquals($this->view->getAssets()['global_assets'],$arrayMustBe);
    }
}
