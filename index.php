<?php

require 'myautoloader.php';

try {
    $router = new core\Router();
} catch (Exception $e) {
    $errorMessageToLog = date("d-m-Y h:m:s") . ' '
        . $e->getMessage() . ' in file ' . $e->getFile()
        . ' on line: ' . $e->getLine() .  PHP_EOL;
    file_put_contents('logs/Errors.log',$errorMessageToLog,FILE_APPEND);
    include 'view/error.php';
}





