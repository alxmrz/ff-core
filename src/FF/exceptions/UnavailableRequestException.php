<?php

namespace FF\exceptions;

use Exception;

class UnavailableRequestException extends Exception
{
    public function showErrorMessage(): void
    {
        echo 'BAD REQUEST';
        exit();
    }
}