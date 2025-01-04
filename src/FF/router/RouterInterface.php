<?php

declare(strict_types=1);

namespace FF\router;

use Closure;
use FF\http\RequestInterface;
use FF\router\RouteHandler;

interface RouterInterface
{
    public function parseRequest(RequestInterface $request): array;
    public function get(string $path, Closure $handler): RouteHandler;
    public function post(string $path, Closure $handler): RouteHandler;
}
