<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Site{
  public $header;
  public $body;
  public $footer;
  public function __constract($header,$body,$footer)
  {
    $this->header=$header;
    $this->body=$body;
    $this->footer=$footer;
  }

  public function pageInitialization($template,$data)
  {
    $header->showYourself();
    $body->showYourself($template,$data);
    $footer->showYourself();
  } 
}