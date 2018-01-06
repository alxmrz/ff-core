<?php

namespace controller;

use core\Controller;

/**
 * Description of skillsController
 *
 * @author Alexandr
 */
class skillsController extends Controller
{

  public function __construct()
  {
    $this->view = new \core\View();
    $this->view->render('skills');
  }

  /**
   * Генерирует страницу
   */
  public function generatePage()
  {
    $this->view->setTitle('Умения');

    $mainData = [
        'contentTemplate' => 'skills.twig',
        'title' => $this->view->getTitle(),
        'globalCss' => $this->view->getGlobalCss(),
        'globalJs' => $this->view->getGlobalJs(),
        'localCss' => $this->view->addLocalCss('skills/css/skills.css'),  
    ];
    echo $this->view->render('layouts/main', $mainData);
  }

}
