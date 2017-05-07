<?php

function myAutoloader($class)
{
    if (preg_match('/\\\\/', $class)) {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    } else {
        $class = str_replace("_", DIRECTORY_SEPARATOR, $class);
    }
    require_once $class . '.php';
}

spl_autoload_register('myAutoloader');
