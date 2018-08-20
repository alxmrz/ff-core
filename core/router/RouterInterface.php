<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 20.08.18
 * Time: 12:16
 */

namespace core\router;


interface RouterInterface
{
    public function parseUri();

    public function getController(): string;

    public function getAction(): string;
}