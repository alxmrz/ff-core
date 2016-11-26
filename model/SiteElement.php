<?php
namespace model\SiteElement;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Site_Element
 *
 * @author Alexandr
 */
abstract class SiteElement {
  abstract function showYourself();
  public function insertCSS($cssText)
  {
    echo "<style type'text/css'>{$cssText}</style>";
  }
  public function insertJavaScript($javascriptText)
  {
    echo "<script type'text/javascript' src='{$javascriptText}'></javascript>";
  }  
}
