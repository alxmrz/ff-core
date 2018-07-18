<?php

namespace core;
use core\exceptions\UnavailableRequestException;

/**
 * Description of Router
 *
 * @author alexandr
 */
class Router
{


  /**
   * Массив доступных запросов, которые можно отобразить, иначе 404 ошибка
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
   * Проверяет валидность запроса страницы
   * @return boolen 
   * @throws UnavailableRequestException если вызванный запрос не существует 
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
