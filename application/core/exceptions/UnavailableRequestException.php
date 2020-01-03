<?php

namespace core\exceptions;

class UnavailableRequestException extends \Exception
{
    public function showErrorMessage()
    {
        echo 'BAD REQUEST';
        exit();
    }
}