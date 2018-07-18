<?php

namespace controller;

use core\Controller;

class MainpageController extends Controller
{

  /**
   * Экземпляр класса View
   * @var \core\View
   */
  private $view;

  public function __construct()
  {
    $this->view = new \core\View();
  }

  /**
   * Генерирует всю страницу целиком
   */
  public function generatePage()
  {
    $this->view->setTitle('Главная страница');

    $mainData = [
        'contentTemplate' => 'mainpage.twig',
        'title' => $this->view->getTitle(),
        'globalCss' => $this->view->getGlobalCss(),
        'globalJs' => $this->view->getGlobalJs(),
        'localCss' => $this->view->addLocalCss('mainpage/css/mainpage.css'),  
    ];
    echo $this->view->render('layouts/main', $mainData);
  }

}
