<?php

declare(strict_types=1);

namespace FF\router;

use \Closure;
use FF\http\RequestInterface;
use FF\http\ResponseInterface;

class RouteHandler
{
    /**
     * @var Closure[]
     */
    private array $middleWares = [];

    public function __construct(private readonly Closure $handler)
    {
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

    public function add(Closure $middleWare): void
    {
        $this->middleWares[] = $middleWare;
    }
}
