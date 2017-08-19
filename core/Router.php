<?php

namespace core;

use core\HttpDemultiplexer;

/**
 * Description of router
 */
class Router
{

  private $controller;
  private $httpDemultiplexer;

  public function __construct($config)
  {
    $this->httpDemultiplexer = new HttpDemultiplexer;
    $this->attachControllerToRouter($this->generateControllerName(), $config);
  }

  private function generateControllerName(): String
  {
    $server = $this->httpDemultiplexer->getServer();
    $urlParams = explode('/', ($server['REQUEST_URI']));

    if (!empty($urlParams[1])) {
      $pageController = 'controller\\' . $urlParams[1] . 'Controller';
    } else {
      $pageController = 'controller\mainpageController';
    }
    return $pageController;
  }

  private function attachControllerToRouter(String $pageController, array $config)
  {
    try {
      $this->controller = new $pageController($config);
    } catch (Exception $e) {
      $errorMessage = $e->getMessage();
      require '/view/error.php';
      exit();
    }
  }

  public function startApplication()
  {
    return $this->controller->generatePage();
  }

  public function getController()
  {
    return $this->controller;
  }

  public function getHttpDemultiplexer()
  {
    return $this->httpDemultiplexer;
  }

}
