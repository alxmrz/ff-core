<?php

namespace tests\tests\core;

use core\container\PHPDIContainer;
use \core\view\TwigEngine;
use PHPUnit\Framework\TestCase;

class TwigEngineTest extends TestCase
{
    /**
     * @var TwigEngine
     */
    private $twigEngine;

    const TEMPLATES_PATH = __DIR__ . '/../../templates/';

    public function setUp()
    {
        $definitions = require __DIR__ . '/../../../config/definitions.php';
        $container = new PHPDIContainer($definitions);
        $this->twigEngine = $container->get(TwigEngine::class);
        $this->twigEngine->setTemplatePath(self::TEMPLATES_PATH);
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

    public function testAllArrayDataIsGot()
    {
        $content = $this->twigEngine->render('arrayPage', ['var' => 'var', 'newLine' => 'new line here']);
        $this->assertRegexp('/super var/', $content);
        $this->assertRegexp('/new line here/', $content);
        $this->assertNotRegExp('/it does not exist/', $content);
    }

    public function testExceptionIfTemplateDoesNotExist()
    {
        $this->expectException(\core\exceptions\FileDoesNotExist::class);
        $content = $this->twigEngine->render('no_template');

    }
}
