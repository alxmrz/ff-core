<?php

namespace FF;

use FF\request\Request;
use Psr\Container\ContainerInterface;

abstract class BaseApplication
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $config;

    public function __construct(ContainerInterface $container, array $config = [])
    {
        $this->container = $container;
        $this->config = $config;
    }

    /**
     * @return int
     */
    abstract public function run();
}