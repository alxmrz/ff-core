<?php

namespace FF\router;

use \Closure;
use FF\http\RequestInterface;
use FF\http\ResponseInterface;

class RouteHandler
{
    private Closure $handler;
    /**
     * @var Closure[]
     */
    private array $middleWares = [];

    public function __construct(Closure $handler) {
        $this->handler = $handler;
    }

    public function getFunc(): Closure
    {
        return $this->handler;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args = []): void
    {
        foreach ($this->middleWares as $mw) {
            if ($mw($request, $response, ...$args) === false) {
                return;
            }
        }

        ($this->handler)($request, $response, ...$args);
    }

    public function add(Closure $middleWare)
    {
        $this->middleWares[] = $middleWare;
    }
}
