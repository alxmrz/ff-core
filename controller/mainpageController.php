<?php
namespace controller;
class mainpageController
{

  function __construct()
  {
    //echo 'I have done mainpageController';
    $this->view = new \core\View();
    $this->view->render('mainpage');
  }
  public function index ()
  {
    $this->view->render('mainpage');
  }
  public function somePage ()
  {
    $this->view->render('');
  }
}
