<?php

declare(strict_types=1);

namespace FF\http;

use FF\Security;

class Request implements RequestInterface
{
    private readonly array $get;
    private readonly array $post;
    private array $server;

    public function __construct()
    {
        $this->get = Security::filterGetInput();
        $this->post = Security::filterPostInput();
        $this->server = $_SERVER;
    }

    /**
     * Возвращает массив $_GET
     */
    public function get(): array
    {
        return $this->get;
    }

    public function post(): array
    {
        return $this->post;
    }

    /**
     * @param string|null $param
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
