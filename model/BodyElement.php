<?php
namespace model\BodyElement;
use model\SiteElement\SiteElement as SiteElement;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Body_Element
 *
 * @author Alexandr
 */
class BodyElement extends SiteElement {
  //put your code here
  protected $template;
  public function __construct($template)
  {
    $this->template=$template;
  }
  public function showYourself() 
  {
    require "view/{$this->template}/{$this->template}.php";
  }

}
