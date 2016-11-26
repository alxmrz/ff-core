<?php


/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function classAutoloader($class)
 {
   $path = str_replace('\\', DIRECTORY_SEPARATOR , $class);
   $tmpPath = explode(DIRECTORY_SEPARATOR,$class);
   array_pop($tmpPath);    
   $endPath = implode(DIRECTORY_SEPARATOR,$tmpPath);

   if(!require_once "{$endPath}.php")
   {
     echo 'No file found';
   }
 }