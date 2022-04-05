<?php

namespace FF\container;

use DI\Container;
use DI\ContainerBuilder;
use Exception;
use Psr\Container\ContainerInterface;

class PHPDIContainer implements ContainerInterface
{
    private Container $container;

    /**
     * @throws Exception
     */
    public function __construct($definitions = [])
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions($definitions);
        $this->container = $builder->build();
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function get(string $id): mixed
    {
        return $this->container->get($id);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return $this->container->has($id);
    }
}
