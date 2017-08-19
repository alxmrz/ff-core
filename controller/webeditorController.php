<?php

namespace controller;

class webeditorController
{

  protected $db;

  function __construct()
  {
    $this->db = \core\DatabaseConnection::getInstance()->getPDO();
    $this->view = new \core\View();
    $this->actions();
    $this->view->render('webeditor');
  }

  /**
   * Выполняет инструкции в зависимости от типа действия перед 
   * отображением шаблона
   */
  protected function actions()
  {
    $post = \core\Securety::filterPostInput();
    if (isset($post['action']) && isset($post['name']) && isset($post['comment'])) {
      switch ($post['action']) {
        
      }
      header("Location: /webeditor/");
    }
  }

}
