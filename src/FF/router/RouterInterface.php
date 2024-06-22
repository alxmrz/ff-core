<?php

declare(strict_types=1);

namespace FF\router;

use Closure;
use FF\http\RequestInterface;

interface RouterInterface
{
    public function parseRequest(RequestInterface $request): array;
    public function get(string $path, Closure $handler): void;
    public function post(string $path, Closure $handler): void;
}
