<?php

declare(strict_types=1);

namespace FF\exceptions;

use Exception;
use Throwable;

class UnavailableRequestException extends Exception
{
    public function __construct(
        string     $message = "No handlers for request found",
        int        $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}