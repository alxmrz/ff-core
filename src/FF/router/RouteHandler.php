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
    private array $mws = [];

    public function __construct(Closure $handler) {
        $this->handler = $handler;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response): void
    {
        foreach ($this->mws as $mw) {
            $mw();
        }

        ($this->handler)($request, $response);
    }

    public function add(Closure $mw)
    {
        $this->mws[] = $mw;
    }
}
