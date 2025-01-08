<?php

declare(strict_types=1);

namespace FF;

use Closure;
use FF\exceptions\ActionNotFound;
use FF\exceptions\ControllerNotFound;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionFunction;

class ReflectionArgsInjector
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function injectHandlerArgs(Closure $handler, array $args): array
    {
        $funcParams = (new ReflectionFunction($handler))->getParameters();

        return $this->injectParamsToArgs($args, $funcParams);
    }

    public function injectActionArgs(string $controllerName, string $action, array $args): array
    {
        if (!class_exists($controllerName)) {
            throw new ControllerNotFound("Controller $controllerName not found");
        } 

        $controllerRef = new ReflectionClass( $controllerName);

        if (!$controllerRef->hasMethod($action)){  
            throw new ActionNotFound("Action $action not found in controller $controllerName");
        }
        
        $funcParams = $controllerRef->getMethod($action)->getParameters();

        return $this->injectParamsToArgs($args, $funcParams);
    } 
    
    private function injectParamsToArgs(array $args, array $funcParams): array
    {
        // Need to delete Request and Response first two params from results
        $result = array_slice(array_values($args), 2);

        foreach ($funcParams as $funcParam) {
            if (isset($args[$funcParam->getName()])) {
                continue;
            }
            
            $result[] = $this->container->get($funcParam->getType()->getName());
        }
        
        return $result;
    }
}