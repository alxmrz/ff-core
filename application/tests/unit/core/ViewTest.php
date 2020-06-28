<?php
declare(strict_types=1);

use core\view\View;
use tests\unit\CustomTestCase;

final class ViewTest extends CustomTestCase
{

    public $view;

    public function setUp()
    {
        parent::setUp();
        $_SERVER['REQUEST_URI'] = 'http://job/mainpage/';
        $this->view = $this->nativeContainer->get(View::class);
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
        $this->assertEquals($this->view->getAssets()['global_assets'], $arrayMustBe);
    }

    public function testAddingGlobalCss()
    {
        $this->assertContains("<link href='/assets/global/css/", $this->view->getGlobalCss());
    }

    public function testAddingGlobalJs()
    {
        $this->assertContains("<script src='/assets/global/js/", $this->view->getGlobalJs());
    }

    public function testAddingLocalCss()
    {
        $this->assertContains("<link href='/assets/mainpage/css/", $this->view->addLocalCss('mainpage/css/'));
    }

    public function testAddingLocalJs()
    {
        $this->assertContains("<script src='/assets/mainpage/js/", $this->view->addLocalJs('mainpage/js/'));
    }

    public function testAddingCssFromAPath()
    {
        $this->assertContains("<link href='/path/to/css/", $this->view->addCssFrom('/path/to/css/'));
    }
}
