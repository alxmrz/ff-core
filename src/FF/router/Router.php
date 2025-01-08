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
     * @param string $path
     * @param Closure $handler
     * @return RouteHandler
     * @throws MethodAlreadyRegistered
     */
    public function get(string $path, Closure $handler): RouteHandler
    {
        return $this->registerHandler("GET", $path, $handler);
    }

    /**
     * @param string $path
     * @param Closure $handler
     * @return RouteHandler
     * @throws MethodAlreadyRegistered
     */
    public function post(string $path, Closure $handler): RouteHandler
    {
        return $this->registerHandler("POST", $path, $handler);
    }

    /**
     * @param string $method
     * @param string $path
     * @param Closure $handler
     * @return RouteHandler
     * @throws MethodAlreadyRegistered
     */
    private function registerHandler(string $method, string $path, Closure $handler): RouteHandler
    {
        if (!isset($this->handlers[$method])) {
            $this->handlers[$method] = [];
        }

        if (isset($this->handlers[$method][$path])) {
            throw new MethodAlreadyRegistered("Method {$method} {$path} already registered!");
        }

        $routeHandler = new RouteHandler($handler);

        $this->handlers[$method][$path] = $routeHandler;

        return $routeHandler;
    }

    /**
     * @param RequestInterface $request
     * @return array
     * @throws UnavailableRequestException
     * @throws Exception
     */
    public function parseRequest(RequestInterface $request): array
    {
        $controller = $action = null;

        $requestMethod = $request->server('REQUEST_METHOD');
        $requestUri = $request->server('REQUEST_URI');

        [$handler, $args] = $this->findHandlerForUri($requestMethod, $requestUri);

        if ($handler === null) {
            [$controller, $action] = $this->findControllerForUri($requestUri);
        }

        return [$handler, $args, $controller, $action];
    }

    /**
     * @param string $requestMethod
     * @param string $requestUri
     * @return array
     */
    private function findHandlerForUri(string $requestMethod, string $requestUri): array
    {
        $requestUri = parse_url($requestUri, PHP_URL_PATH);

        if ($handler = $this->findSimpleHandler($requestMethod, $requestUri)) {
            return [$handler, []];
        }

        return $this->findHandlerWithArgs($requestMethod, $requestUri);
    }

    private function findSimpleHandler(string $requestMethod, string $requestUri)
    {
        return $this->handlers[$requestMethod][$requestUri] ?? null;
    }

    private function findHandlerWithArgs(string $requestMethod, string $requestUri): array
    {
        $handler = null;
        $routeArgs = [];

        $requestRoute = new ArgsRoute($requestUri);

        foreach ($this->getHandlersForMethod($requestMethod) as $route => $func) {
            $route = new ArgsRoute($route);
            if (!$requestRoute->hasPartsCountEqualedTo($route)) {
                continue;
            }

            if ($routeArgs = $requestRoute->extractArgsByTemplateRoute($route)) {
                $handler = $func;

                break;
            }
        }

        return [$handler, $routeArgs];
    }

    private function getHandlersForMethod(string $requestMethod): array
    {
        return $this->handlers[$requestMethod] ?? [];
    }

    /**
     * @param array|string $requestUri
     * @return array
     * @throws Exception
     */
    private function findControllerForUri(array|string $requestUri): array
    {
        if (!isset($this->config['controllerNamespace'])) {
            return ['', ''];
        }

        return $this->findControllerWithActionForUri($requestUri);
    }

    /**
     * @param string $uri
     * @return array
     */
    private function findControllerWithActionForUri(string $uri): array
    {
        $explodedArray = explode('/', ($uri));
        $controllerName = 'MainpageController';

        if (!empty($explodedArray[1])) {
            $controllerName = ucfirst($explodedArray[1]) . 'Controller';
        }

        $action = empty($explodedArray[2])
            ? 'actionIndex'
            : $this->parseAction($explodedArray[2]);
            
        return [$controllerName, $action];
    }

    /**
     * @param $haystack
     * @return string
     */
    private function parseAction($haystack): string
    {
        if (str_contains($haystack, '-')) {
            $actionParts = explode('-', $haystack);
            foreach ($actionParts as &$actionPart) {
                $actionPart = ucfirst($actionPart);
            }
            $actionPartName = implode($actionParts);
        } else {
            $actionPartName = ucfirst($haystack);
        }

        return "action{$actionPartName}";
    }
}
