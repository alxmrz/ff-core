<?php
namespace model\HeaderElement;
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
class HeaderElement extends SiteElement 
{
  protected $link;
  protected $title;
  public function __construct($link) 
  {
   $this->link=$link;
  }
  public function setTitle($title)
  {
    $this->title=$title;
  }
  public function showYourself() 
  {
    $link = $this->link;
    require 'view/header.php';
  }
  

}
