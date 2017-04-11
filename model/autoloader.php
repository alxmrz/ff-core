<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class model_Autoloader
{

    public static function classAutoloader($class)
    {
        if (preg_match('\\\\', $class)) {
            $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        } else {
            $path = str_replace("_", DIRECTORY_SEPARATOR, $class);
        }

        $tmpPath = explode(DIRECTORY_SEPARATOR, $class);
        array_pop($tmpPath);
        $endPath = implode(DIRECTORY_SEPARATOR, $tmpPath);

        if (file_exist("{$endPath}.php")) {
            require_once "{$endPath}.php";
        } else {
            $error = "The file: {$endPath}.php does not exist!";
            require error . php;
        }
    }

}
