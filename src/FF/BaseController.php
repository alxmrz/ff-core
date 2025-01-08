<?php

declare(strict_types=1);

namespace FF;

use FF\router\RouterInterface;

abstract class BaseController
{
    protected RouterInterface $router;

    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    public function setRouter(RouterInterface $router): void
    {
        $this->router = $router;
    }
}
