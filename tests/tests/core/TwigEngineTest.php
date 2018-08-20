<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 19.08.18
 * Time: 14:13
 */

namespace tests\tests\core;

use \core\view\TwigEngine;
use PHPUnit\Framework\TestCase;

class TwigEngineTest extends TestCase
{
    private $twigEngine;

    const templatesPath = __DIR__ . '/../../templates/twig';

    public function setUp()
    {;
        $loader = new \Twig_Loader_Filesystem(self::templatesPath);
        $twig = new \Twig_Environment($loader, array(
            'cache' => '../cache/twig/',
            'debug' => true
        ));
        $this->twigEngine = new TwigEngine(self::templatesPath, $loader, $twig);
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
