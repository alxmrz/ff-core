<?php
namespace model\FooterElement;
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

use model\SiteElement\SiteElement as Site_Element;

class FooterElement extends Site_Element 
{
  protected $link;
  public function __construct($link)
  {
    $this->link = $link;
  }
  public function showYourself() 
  {
    $link = $this->link;
    require 'view/footer.php';

  }

}
