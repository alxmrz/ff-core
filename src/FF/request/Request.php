<?php
namespace FF\request;

use FF\Security;

class Request implements RequestInterface
{
    /**
     * @var array
     */
    private $get;

    /**
     * @var array
     */
    private $post;

    /**
     * Массив $_SERVER
     * @var array
     */
    private $server;

    public function __construct()
    {
        $this->get = Security::filterGetInput();
        $this->post = Security::filterPostInput();
        $this->server = $_SERVER;
    }

    /**
     * Возвращает массив $_GET
     * @return array
     */
    public function get()
    {
        return $this->get;
    }

    /**
     * @return array
     */
    public function post()
    {
        return $this->post;
    }

    /**
     * @param string|null $param
     * @return array|mixed|string
     */
    public function server(string $param = null)
    {
        if ($param !== null) {
            return $this->server[$param] ?? '';
        }
        return $this->server;
    }

}
