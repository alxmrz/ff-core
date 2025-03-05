<?php

declare(strict_types=1);

namespace FF\container;

use DI\Container;
use DI\ContainerBuilder;
use Exception;
use Psr\Container\ContainerInterface;

class PHPDIContainer implements ContainerInterface
{
    private readonly Container $container;

    /**
     * @throws Exception
     */
    public function __construct($definitions = [])
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions($definitions);
        $this->container = $builder->build();
    }

    public function get(string $id): mixed
    {
        return $this->container->get($id);
    }

    public function has(string $id): bool
    {
        return $this->container->has($id);
    }
}
