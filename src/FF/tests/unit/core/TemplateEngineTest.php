<?php

/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 19.08.18
 * Time: 14:13
 */

namespace tests\tests\core;

use FF\view\TemplateEngine;
use PHPUnit\Framework\TestCase;
use FF\tests\unit\CommonTestCase;

class TemplateEngineTest extends CommonTestCase
{
    private $templateEngine;

    public function setUp(): void
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
        $this->assertMatchesRegularExpression('/super var/', $content);
        $this->assertMatchesRegularExpression('/new line here/', $content);
        $this->assertDoesNotMatchRegularExpression('/it does not exist/', $content);
    }

    public function testExceptionIfTemplateDoesNotExist()
    {
        $this->expectException(\FF\exceptions\FileDoesNotExist::class);
        $content = $this->templateEngine->render('no_template');
    }
}
