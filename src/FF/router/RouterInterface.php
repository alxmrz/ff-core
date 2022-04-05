<?php
namespace FF\router;

interface RouterInterface
{
    public function parseUri(string $uri);

    public function getController(): string;

    public function getAction(): string;
}