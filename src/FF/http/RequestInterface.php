<?php
namespace FF\http;


interface RequestInterface
{
    public function get(): array;

    public function post(): array;

    public function server(string $param = null): array|string;

    public function context(): array;
}