<?php
  namespace core;

  class HttpDemultiplexer
  {
    private $get;
    private $post;
    private $server;

    public function __construct()
    {
      $this->get = $_GET;
      $this->post = $_POST;
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
