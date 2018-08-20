<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 20.08.18
 * Time: 12:16
 */

namespace core\request;


interface RequestInterface
{
    public function get();

    public function post();

    public function server();
}