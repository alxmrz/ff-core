<?php

namespace FF;

use Psr\Container\ContainerInterface;

abstract class BaseApplication
{
    public function __construct(
        protected ContainerInterface $container,
        protected array $config = []
    ){}

    /**
     * @return int
     */
    abstract public function run(): int;
}
