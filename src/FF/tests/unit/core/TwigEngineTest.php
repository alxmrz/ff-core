<?php

use FF\exceptions\FileDoesNotExist;
use FF\view\TwigEngine;
use FF\tests\unit\CommonTestCase;

class TwigEngineTest extends CommonTestCase
{
    /**
     * @var TwigEngine
     */
    private TwigEngine $twigEngine;


    public function setUp(): void
    {
        parent::setUp();
        $templatePath = __DIR__ . '/../../templates/';
        $this->twigEngine = new TwigEngine($templatePath, new Twig_Environment(new Twig_Loader_Filesystem($templatePath)));
    }

    public function testRenderReturnsContent()
    {
        $content = $this->twigEngine->render('contentPage');
        $this->assertEquals('content_page', $content);
        $content = $this->twigEngine->render('secondPage');
        $this->assertEquals('second_page', $content);
        $content = $this->twigEngine->render('thirdPage');
        $this->assertEquals('third_page', $content);
    }

    /**
     * @throws FileDoesNotExist
     */
    public function testAllArrayDataIsGot()
    {
        $content = $this->twigEngine->render('arrayPage', ['var' => 'var', 'newLine' => 'new line here']);
        $this->assertMatchesRegularExpression('/super var/', $content);
        $this->assertMatchesRegularExpression('/new line here/', $content);
        $this->assertDoesNotMatchRegularExpression('/it does not exist/', $content);
    }

    public function testExceptionIfTemplateDoesNotExist()
    {
        $this->expectException(FileDoesNotExist::class);
        $this->twigEngine->render('no_template');
    }
}
