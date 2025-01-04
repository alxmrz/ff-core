<?php

namespace FF\tests\unit\core\http;

use FF\http\Response;

class ResponseTest extends \FF\tests\unit\CommonTestCase
{
    /**
     * @runInSeparateProcess
     *
     * @return void
     * @throws \Exception
     */
    public function testSend()
    {
        $response = new Response();
        $response->withBody('test-body');

        $this->expectOutputString('test-body');

        $response->send();
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     * @throws \Exception
     */
    public function testSend_EmptyBody()
    {
        $response = new Response();

        $this->expectOutputString('');

        $response->send();
    }


    /**
     * @runInSeparateProcess
     *
     * @return void
     * @throws \Exception
     */
    public function testSendWithJsonBody()
    {
        $response = new Response();
        $response->withJsonBody(['key' => 'value']);

        $this->expectOutputString('{"key":"value"}');

        $response->send();
    }
}