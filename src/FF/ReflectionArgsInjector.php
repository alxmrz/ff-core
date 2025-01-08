<?php

declare(strict_types=1);

namespace FF;

use Closure;
use FF\exceptions\UnavailableRequestException;
use ReflectionClass;
use ReflectionFunction;
use Psr\Container\ContainerInterface;

class ReflectionArgsInjector
{
    private ContainerInterface $container;
    private array $config;

    public function __construct(ContainerInterface $container, array $config)
    {
        $this->container = $container;
        $this->config = $config;
    }

    public function injectHandlerArgs(Closure $handler, array $args): array
    {
        $result = array_slice(array_values($args), 2);

        $funcRef = new ReflectionFunction($handler);

        $funcParams = $funcRef->getParameters();

        foreach ($funcParams as $funcParam) {
            if (isset($args[$funcParam->getName()])) {
                continue;
            }

            $result[] = $this->container->get($funcParam->getType()->getName());
        }

        return $result;
    }


    public function injectActionArgs(string $controllerName, string $action, array $args): array
    {
        if (!class_exists($controllerName)) {
            throw new UnavailableRequestException("Controller $controllerName not found");
        } 

        $controllerRef = new ReflectionClass( $controllerName);

        if (!$controllerRef->hasMethod($action)){  
            throw new UnavailableRequestException("Action $action not found in controller $controllerName");
        }
        
        $result = array_slice(array_values($args), 2);

        $funcRef = $controllerRef->getMethod($action);

        $funcParams = $funcRef->getParameters();

        foreach ($funcParams as $funcParam) {
            if (isset($args[$funcParam->getName()])) {
                continue;
            }
            
            $result[] = $this->container->get($funcParam->getType()->getName());
        }
        
        return $result;
    }
}