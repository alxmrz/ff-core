<?php
namespace FF\request;


interface RequestInterface
{
    public function get(): array;

    public function post(): array;

    public function server(): array|string;
}