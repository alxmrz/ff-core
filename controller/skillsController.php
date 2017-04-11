<?php
namespace controller;
/**
 * Description of skillsController
 *
 * @author Alexandr
 */
class skillsController
{
  function __construct()
  {
    echo 'I have done skillsController';
    $this->view = new \core\View();
    $this->view->render('skills');
  }
  public function index ()
  {
    $this->view->render('skills');
  }
  public function somePage ()
  {
    $this->view->render('');
  }
}
