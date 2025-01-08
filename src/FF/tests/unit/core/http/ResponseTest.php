<?php
// With FF\http we rewrite default header function to test it
namespace FF\http;

use FF\tests\unit\core\http\ResponseTest;

function header (string $header) {
    ResponseTest::collectHeader($header);
}

// Real file namespace
namespace FF\tests\unit\core\http;

use FF\http\Response;

class ResponseTest extends \FF\tests\unit\CommonTestCase
{
    public static array $headersSent = [];

    public function setUp(): void
    {
        self::$headersSent = [];
    }

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

    public function testSend_WhenHeadersAlreadySentThenException(): void
    {
        $response = new Response();

        $this->expectExceptionMessage('Headers are already sent');

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

    /**
     * @runInSeparateProcess
     *
     * @return void
     * @throws \Exception
     */
    public function testSendWithHeader()
    {
        $response = new Response();
        $response->withHeader("MyHeader", 'value');

        $this->expectOutputString('');

        $response->send();

        $this->assertEquals(['MyHeader: value'], self::$headersSent);
    }

        /**
     * @runInSeparateProcess
     *
     * @return void
     * @throws \Exception
     */
    public function testSendWithHeader_WhenHeaderAlreadyDefinedThenException()
    {
        $response = new Response();

        $this->expectExceptionMessage("Header <MyHeader> is already defined!");

        $response->withHeader("MyHeader", 'value');
        $response->withHeader("MyHeader", 'value');
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     * @throws \Exception
     */
    public function testSendWithStatusCode(): void
    {
        $response = new Response();
        $response->withStatusCode(401);

        $response->send();

        $this->assertEquals(401, http_response_code());
    }

    public static function collectHeader(string $header): void
    {
        self::$headersSent[] = $header;
    }
}