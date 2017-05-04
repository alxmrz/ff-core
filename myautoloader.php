<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function myAutoloader($class) 
{
    if (preg_match('/\\\\/', $class)) {
            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    } else {
        $class = str_replace("_", DIRECTORY_SEPARATOR, $class);
    }
    //echo $class . '<br />';
    //echo file_get_contents($class . '.php');
    require_once $class . '.php';
   
}
spl_autoload_register('myAutoloader');
