<?php
namespace model\Securety;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Securety
{
  public static function checkUserInput($get)
  {
    return htmlspecialchars(trim($get));
  }
}



