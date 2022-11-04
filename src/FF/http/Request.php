<?php

declare(strict_types=1);

namespace FF\http;

use FF\Security;

class Request implements RequestInterface
{
    private array $get;
    private array $post;
    private array $server;

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
    public function get(): array
    {
        return $this->get;
    }

    /**
     * @return array
     */
    public function post(): array
    {
        return $this->post;
    }

    /**
     * @param string|null $param
     * @return array|string
     */
    public function server(string $param = null): array|string
    {
        if ($param !== null) {
            return $this->server[$param] ?? '';
        }

        return $this->server;
    }

    public function context(): array
    {
        return [
            'request' => $this->server('REQUEST_URI'),
            'ip' => $this->server('REMOTE_ADDR')
        ];
    }
}
