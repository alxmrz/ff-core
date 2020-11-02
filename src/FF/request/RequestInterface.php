<?php
namespace FF\request;


interface RequestInterface
{
    public function get();

    public function post();

    public function server();
}