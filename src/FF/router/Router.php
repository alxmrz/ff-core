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
        $controller = $action = null;

        $requestMethod = $request->server('REQUEST_METHOD');
        $requestUri = $request->server('REQUEST_URI');
        $handler = $this->handlers[$requestMethod][$requestUri] ?? null;
        if ($handler === null) {
            if (!isset($this->config['controllerNamespace'])) {
                throw new Exception('Params controllerNamespace is not specified in app config');
            }

            [$controller, $action] = $this->parseUrlParams($requestUri);
        }

        if ($handler === null && ($controller === null || $action === null)) {
            throw new UnavailableRequestException();
        }

        return [$handler, $controller, $action];
    }

    /**
     * @param string $uri
     * @return array
     */
    private function parseUrlParams(string $uri): array
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
