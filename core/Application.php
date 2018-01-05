<?php

namespace core;

use core\HttpDemultiplexer;
use core\exceptions\UnavailableRequestException;

/**
 * Класс Application - основной класс приложения. 
 */
class Application
{

  private $controller;
  private $httpDemultiplexer;
  private $pageToRender;
  private $runResult = 1;
  private $params;
  private $requestsExpected = array(
      'mainpage',
      'skills',
      'feedback'
  );

  public function run()
  {
    return $this->runResult === 1 ? $this->controller->generatePage() : '';
  }

  public function __construct(array $config = [])
  {
    try {
      $this->httpDemultiplexer = new HttpDemultiplexer;
      $this->setUrlParams();
      $this->registerController($config);
    } catch (UnavailableRequestException $unex) {
      $this->showErrorPage($unex , '404 Страница не найдена');
    } catch (\Exception $ex) {
      $this->showErrorPage(ex);
    }
  }

  private function showErrorPage(\Exception $ex, string $additionInfo = '')
  {
    $this->runResult = 0;
    $additionInfo = $additionInfo;
    $errorMessage = $ex->getMessage();
    require '../view/error.php';
  }

  /**
   * Ищет по URI запрашиваемый запрос
   */
  private function setUrlParams(): void
  {
    $server = $this->httpDemultiplexer->getServer();
    $explodedArray = explode('/', ($server['REQUEST_URI']));
    $this->pageToRender = $explodedArray[1];
    if (empty($this->pageToRender)) {
      $this->pageToRender = 'mainpage';
    }

    $this->isRequestExpected();
  }

  /**
   * Проверяет валидность запроса страницы
   * @return boolen 
   * @throws UnavailableRequestException если вызванный запрос не существует 
   */
  private function isRequestExpected(): bool
  {
    if (in_array($this->pageToRender, $this->requestsExpected)) {
      return true;
    }
    throw new UnavailableRequestException("REQUEST {$this->pageToRender} IS NOT AVAILIBLE");
  }

  private function registerController(array $config = []): void
  {

    $pageController = 'controller\\' . $this->pageToRender . 'Controller';

    $this->controller = new $pageController($config);
  }

  public function getHttpDemultiplexer(): HttpDemultiplexer
  {
    return $this->httpDemultiplexer;
  }

  public function getController(): \core\Controller
  {
    return $this->controller;
  }

  public function getPageToRender(): string
  {
    return $this->pageToRender;
  }

}
