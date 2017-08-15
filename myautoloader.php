<?php

function myAutoloader($class)
{
    if (preg_match('/\\\\/', $class)) {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    } else {
        $class = str_replace("_", DIRECTORY_SEPARATOR, $class);
    }

    if(file_exists(__DIR__ . '/' . $class . '.php')) {
        require_once __DIR__ . '/' . $class . '.php';
    }

}

spl_autoload_register('myAutoloader');
