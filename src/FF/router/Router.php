<?php

declare(strict_types=1);

namespace FF\router;

use Closure;
use Exception;
use FF\exceptions\MethodAlreadyRegistered;
use FF\exceptions\UnavailableRequestException;
use FF\http\RequestInterface;
use FF\libraries\FileManager;

class Router implements RouterInterface
{
    private array $config;
    private array $handlers = [];
    private FileManager $fileManager;

    public function __construct(FileManager $fileManager, array $config = [])
    {
        $this->config = $config;
        $this->fileManager = $fileManager;
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

        if ($handler === null && ($controller === null || $action === null)) {
            throw new UnavailableRequestException();
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
            throw new Exception('Params controllerNamespace is not specified in app config');
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

        if (!$this->fileManager->isFileExist($this->config['controllerNamespace'] . $controllerName)) {
            $controllerName = null;
        }

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
