<?php

namespace core;
use core\exceptions\UnavailableRequestException;

class Router
{


  /**
   * @var array 
   */
  private $requestsExpected = array(
      'MainpageController',
  );
  private $controller;

  /**
   * 
   * @param string $uri
   * @return array
   */
  public function parseUri($uri)
  {
    $this->setUrlParams($uri);
  }

  /**
   * Ищет по URI запрашиваемый запрос
   * @return void
   */
  private function setUrlParams($uri)
  {
    $explodedArray = explode('/', ($uri));

    if (empty($explodedArray[1])) {
      $this->controller = 'MainpageController';
    } else {
      $this->controller = ucfirst($explodedArray[1]) . 'Controller';
    }
    
    if (empty($explodedArray[2])) {
      $this->action = 'indexAction';
    } else {
      $this->action = "{$explodedArray[2]}Action";
    }
    
    $this->isRequestExpected($this->controller);
  }

  /**
   * @return boolen 
   * @throws UnavailableRequestException
   */
  private function isRequestExpected($controllerPart): bool
  {
    if (in_array($controllerPart, $this->requestsExpected)) {
      return true;
    }
    throw new UnavailableRequestException("REQUEST {$this->controller} IS NOT AVAILIBLE");
  }

  public function getController(): string
  {
    return $this->controller;
  }
  
  public function getAction(): string
  {
    return $this->action;
  }
  
  
}
