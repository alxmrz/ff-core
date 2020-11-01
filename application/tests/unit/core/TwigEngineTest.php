<?php
use \core\view\TwigEngine;
use tests\unit\CommonTestCase;

class TwigEngineTest extends CommonTestCase
{
    /**
     * @var TwigEngine
     */
    private $twigEngine;


    public function setUp()
    {
        parent::setUp();
        $this->twigEngine = $this->nativeContainer->get(TwigEngine::class);
        $this->twigEngine->setTemplatePath(TEMPLATE_PATH);
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
        $this->markTestSkipped('must be revisited.');
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
