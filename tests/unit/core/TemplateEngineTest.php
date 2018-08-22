<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 19.08.18
 * Time: 14:13
 */

namespace tests\tests\core;

use core\view\TemplateEngine;
use PHPUnit\Framework\TestCase;

class TemplateEngineTest extends TestCase
{
    private $templateEngine;

    public function setUp()
    {
        $this->templateEngine = new TemplateEngine(__DIR__ . '/../../templates/');
    }
    public function testRenderReturnsContent()
    {
        $content = $this->templateEngine->render('contentPage');
        $this->assertEquals('content_page', $content);
        $content = $this->templateEngine->render('secondPage');
        $this->assertEquals('second_page', $content);
        $content = $this->templateEngine->render('thirdPage');
        $this->assertEquals('third_page', $content);
    }

    public function testAllArrayDataIsGot()
    {
        $content = $this->templateEngine->render('arrayPage', ['var' => 'var', 'newLine' => 'new line here']);
        $this->assertRegexp('/super var/', $content);
        $this->assertRegexp('/new line here/', $content);
        $this->assertNotRegExp('/it does not exist/', $content);
    }

    public function testExceptionIfTemplateDoesNotExist()
    {
        $this->expectException(\core\exceptions\FileDoesNotExist::class);
        $content = $this->templateEngine->render('no_template');

    }
}
