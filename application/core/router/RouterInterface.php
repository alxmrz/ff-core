<?php
namespace core\router;

interface RouterInterface
{
    public function parseUri();

    public function getController(): string;

    public function getAction(): string;
}