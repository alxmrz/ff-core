<?php

namespace controller;

use core\Controller;
use core\Securety;
use core\View;
use model\feedbackModel;

class feedbackController extends Controller
{

  protected $model;

  public function __construct($config)
  {
    $this->model = new feedbackModel($config);
    $this->view = new View();
    $this->actions($config);
  }

  /**
   *  Генерирует страницу с комментариями
   */
  public function generatePage()
  {
    $this->view->setTitle('Отзывы');
    $data = $this->model->getComments();
    
    $mainData = [
        'contentTemplate' => 'feedback.twig',
        'recalls' => $data,
        'localCss'=> $this->view->addLocalCss('feedback/css/feedback.css'),
        'title' => $this->view->getTitle(),
        'globalCss' => $this->view->getGlobalCss(),
        'globalJs' => $this->view->getGlobalJs()
    ];
    echo $this->view->render('layouts/main', $mainData);
  }

  /**
   * Выполняет инструкции в зависимости от типа действия перед 
   * отображением шаблона
   */
  protected function actions()
  {
    $post = Securety::filterPostInput();
    if (isset($post['action']) && !empty($post['from']) && !empty($post['comment'])) {
      switch ($post['action']) {
        case 'addComment':
          $this->model->addComment();
          break;
      }
      header("Location: /feedback/");
    }
  }

}
