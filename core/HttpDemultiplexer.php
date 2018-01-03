<?php

namespace core;

use core\Securety;

class HttpDemultiplexer
{

  private $get;
  private $post;
  private $server;

  public function __construct()
  {
    $this->get = Securety::filterGetInput();
    $this->post = Securety::filterPostInput();
    $this->server = $_SERVER;
  }

  public function getGet()
  {
    return $this->get;
  }

  public function getPost()
  {
    return $this->post;
  }

  public function getServer()
  {
    return $this->server;
  }

}
