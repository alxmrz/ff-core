<?php

namespace core\request;

use core\Security;

/**
 * Класс, возвращающий обработанные данные GET, POST, SERVER
 */
class Request implements RequestInterface
{
  /**
   * Массив $_GET
   * @var array 
   */
  private $get;
  
  /**
   * Массив $_POST
   * @var array 
   */
  private $post;
  
  /**
   * Массив $_SERVER
   * @var array 
   */
  private $server;
  
  /**
   * Конструктор HttpDemultiplexer
   */
  public function __construct()
  {
    $this->get = Security::filterGetInput();
    $this->post = Security::filterPostInput();
    $this->server = $_SERVER;
  }
  
  /**
   * Возвращает массив $_GET
   * @return array
   */
  public function get()
  {
    return $this->get;
  }
  
  /**
   * Возвращает массив $_POST
   * @return array
   */
  public function post()
  {
    return $this->post;
  }
  
  /**
   * Возвращает массив $_SERVER
   * @return array
   */
  public function server()
  {
    return $this->server;
  }

}
