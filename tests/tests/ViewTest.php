<?php

declare(strict_types = 1);

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
    $this->assertEquals($this->view->getAssets()['global_assets'], $arrayMustBe);
  }

  public function testViewRenderMainpageTemplate()
  {
    $return = $this->view->render('mainpage');
    $this->assertContains('mainpage', $return);
  }

  public function testAddingGlobalCss()
  {
    $this->expectOutputRegex('/(<link href=\'\/assets\/global\/css\/)/');
    $this->view->putGlobalCss();
  }

  public function testAddingGlobalJs()
  {
    $this->expectOutputRegex('/<script src=\'\/assets\/global\/js\//');
    $this->view->putGlobalJs();
  }

  public function testAddingLocalCss()
  {
    $this->expectOutputRegex('/<link href=\'\/assets\//');
    $this->view->addLocalCss('');
  }

  public function testAddingLocalJs()
  {
    $this->expectOutputRegex('/<script src=\'\/assets\//');
    $this->view->addLocalJs(array(''));
  }

  public function testAddingCssFromAPath()
  {
    $this->expectOutputRegex('/<link href=\'/');
    $this->view->addCssFrom('');
  }

}
