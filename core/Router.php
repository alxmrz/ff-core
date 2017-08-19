<?php

namespace core;

use core\HttpDemultiplexer;
use core\exceptions\UnavailableRequestException;

/**
 * Description of router
 */
class Router
{

  private $controller;
  private $httpDemultiplexer;
  private $pageToRender;
  private $params;
  private $requestsExpected = array(
      'mainpage',
      'skills',
      'feedback'
  );

  public function startApplication()
  {
    return $this->controller->generatePage();
  }

  public function __construct($config)
  {
    $this->httpDemultiplexer = new HttpDemultiplexer;
    $this->setUrlParams();
    $this->attachControllerToRouter($this->generateControllerName(), $config);
  }

  /**
   * Ищет по URI запрашиваемый запрос
   */
  private function setUrlParams()
  {
    $server = $this->httpDemultiplexer->getServer();
    $explodedArray = explode('/', ($server['REQUEST_URI']));
    $this->pageToRender = $explodedArray[1];
    if(empty($this->pageToRender)) {
      $this->pageToRender = 'mainpage';
    }
  }

  private function generateControllerName(): String
  {
    if ($this->isRequestExist()) {
      $pageController = 'controller\\' . $this->pageToRender . 'Controller';
    } else {
      $pageController = 'controller\mainpageController';
    }
    return $pageController;
  }

  /**
   * Проверяет существование запроса страницы
   * @return boolen 
   */
  private function isRequestExist()
  {
    return $this->isRequestExpected() && !empty($this->pageToRender);
  }

  private function isRequestExpected()
  {
    if (in_array($this->pageToRender, $this->requestsExpected)) {
      return true;
    }
    throw new UnavailableRequestException("REQUEST IS NOT AVAILIBLE");
  }

  /**
   * 
   * @param String $pageController Название нужного контроллева
   * @param array $config Глобальная конфигурация
   * @throws Exception 
   */
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

  public function getHttpDemultiplexer()
  {
    return $this->httpDemultiplexer;
  }

  public function getController()
  {
    return $this->controller;
  }

}
