<?php

namespace tests\unit\core;

use FF\http\Request;
use FF\tests\unit\CommonTestCase;

class RequestTest extends CommonTestCase
{
    public function testServer()
    {
        $request = $this->createRequest();

        $this->assertEquals('value', $request->server('param'));
        $this->assertCount(1, $request->server());
    }

    protected function createRequest(): Request
    {
        $_SERVER = ['param' => 'value'];
        return new Request();
    }

    public function testGet()
    {
        $this->createRequest()->get();
        $this->assertTrue(true);
    }

    public function testPost()
    {
        $this->createRequest()->post();
        $this->assertTrue(true);
    }
}
