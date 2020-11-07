<?php
namespace FF\router;

interface RouterInterface
{
    public function parseUri();

    public function getController(): string;

    public function getAction(): string;
}