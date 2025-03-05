<?php

declare(strict_types=1);

namespace tests\unit\core;

use FF\http\Request;
use FF\tests\unit\CommonTestCase;

final class RequestTest extends CommonTestCase
{
    public function testServer(): void
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

    public function testGet(): void
    {
        $this->createRequest()->get();
        $this->assertTrue(true);
    }

    public function testPost(): void
    {
        $this->createRequest()->post();
        $this->assertTrue(true);
    }
}
