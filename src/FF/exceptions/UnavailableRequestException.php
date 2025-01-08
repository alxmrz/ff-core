<?php

declare(strict_types=1);

namespace FF\exceptions;

use Exception;
use FF\http\RequestInterface;
use Throwable;

class UnavailableRequestException extends Exception
{
    public function __construct(
        RequestInterface $request,
        ?Throwable $previous = null
    ) {
        $message = 'Not found a handler or a controller for request: ' .
            $request->server()['REQUEST_METHOD'] . ' ' . $request->server()['REQUEST_URI'];

        parent::__construct($message, 0, $previous);
    }
}
