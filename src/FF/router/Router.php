<?php

declare(strict_types=1);

namespace FF\router;

use Closure;
use Exception;
use FF\exceptions\MethodAlreadyRegistered;
use FF\exceptions\UnavailableRequestException;
use FF\http\RequestInterface;

class Router implements RouterInterface
{
    private array $config;
    private array $handlers = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param RequestInterface $request
     * @return array
     * @throws UnavailableRequestException
     */
    public function parseRequest(RequestInterface $request): array
    {
        $args = [];
        $controller = $action = null;

        $requestMethod = $request->server('REQUEST_METHOD');
        $requestUri = $request->server('REQUEST_URI');

        [$handler, $routeArgs] = $this->findHandlerForUri($requestMethod, $requestUri);
        $args = array_merge($args, $routeArgs);

        if ($handler === null) {
            if (!isset($this->config['controllerNamespace'])) {
                throw new Exception('Params controllerNamespace is not specified in app config');
            }

            [$controller, $action] = $this->findControllerWithActionForUri($requestUri);
        }

        if ($handler === null && ($controller === null || $action === null)) {
            throw new UnavailableRequestException();
        }

        return [$handler, $controller, $action, $args];
    }


    /**
     * @param string $requestMethod
     * @param string $requestUri
     * @return array
     */
    private function findHandlerForUri(string $requestMethod, string $requestUri): array
    {
        $routeArgs = [];
        $handler = $this->handlers[$requestMethod][$requestUri] ?? null;
        if ($handler === null) {
            $requestUriParts = explode('/', $requestUri);
            $lenUriParts = count($requestUriParts);
            foreach ($this->handlers[$requestMethod] ?? [] as $route => $func) {
                $routeParts = explode('/', $route);
                if (count($routeParts) !== $lenUriParts) continue;
                foreach ($routeParts as $key => $part) {
                    if ($requestUriParts[$key] === $part) continue;
                    preg_match("/{(\w+)}/", $part, $matches);
                    if (count($matches) > 0) {
                        $routeArgs[$matches[1]] = $requestUriParts[$key];
                    } else {
                        $routeArgs = [];
                        break;
                    }
                }

                if (count($routeArgs) > 0) {
                    $handler = $func;
                    break;
                }
            }

        }
        return [$handler, $routeArgs];
    }

    /**
     * @param string $uri
     * @return array
     */
    private function findControllerWithActionForUri(string $uri): array
    {
        $explodedArray = explode('/', ($uri));

        if (empty($explodedArray[1])) {
            $controllerName = 'MainpageController';
        } else {
            $controllerName = ucfirst($explodedArray[1]) . 'Controller';
        }

        if (empty($explodedArray[2])) {
            $action = 'actionIndex';
        } else {
            if (str_contains($explodedArray[2], '-')) {
                $actionParts = explode('-', $explodedArray[2]);
                foreach ($actionParts as &$actionPart) {
                    $actionPart = ucfirst($actionPart);
                }
                $actionPart = implode($actionParts);
            } else {
                $actionPart = ucfirst($explodedArray[2]);
            }

            $action = "action{$actionPart}";
        }

        return [$controllerName, $action];
    }

    /**
     * @param string $path
     * @param Closure $handler
     * @return void
     * @throws MethodAlreadyRegistered
     */
    public function get(string $path, Closure $handler): void
    {
        $this->registerHandler("GET", $path, $handler);

    }

    /**
     * @param string $path
     * @param Closure $handler
     * @throws MethodAlreadyRegistered
     */
    public function post(string $path, Closure $handler): void
    {
        $this->registerHandler("POST", $path, $handler);
    }

    /**
     * @param string $method
     * @param string $path
     * @param Closure $handler
     * @return void
     * @throws MethodAlreadyRegistered
     */
    private function registerHandler(string $method, string $path, Closure $handler): void
    {
        if (!isset($this->handlers[$method])) {
            $this->handlers[$method] = [];
        }

        if (isset($this->handlers[$method][$path])) {
            throw new MethodAlreadyRegistered("Method {$method} {$path} already registered!");
        }

        $this->handlers[$method][$path] = $handler;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
