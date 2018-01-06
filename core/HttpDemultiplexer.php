<?php

namespace core;

use core\Securety;

/**
 * Класс, возвращающий обработанные данные GET, POST, SERVER
 */
class HttpDemultiplexer
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
    $this->get = Securety::filterGetInput();
    $this->post = Securety::filterPostInput();
    $this->server = $_SERVER;
  }
  
  /**
   * Возвращает массив $_GET
   * @return array
   */
  public function getGet()
  {
    return $this->get;
  }
  
  /**
   * Возвращает массив $_POST
   * @return array
   */
  public function getPost()
  {
    return $this->post;
  }
  
  /**
   * Возвращает массив $_SERVER
   * @return array
   */
  public function getServer()
  {
    return $this->server;
  }

}
