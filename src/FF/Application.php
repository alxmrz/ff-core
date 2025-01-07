<?php

declare(strict_types=1);

namespace FF;

use Closure;
use Exception;
use FF\container\PHPDIContainer;
use FF\exceptions\MethodAlreadyRegistered;
use FF\exceptions\UnavailableRequestException;
use FF\http\Request;
use FF\http\RequestInterface;
use FF\http\Response;
use FF\http\ResponseInterface;
use FF\http\StatusCode;
use FF\libraries\FileManager;
use FF\logger\MonologLogger;
use FF\router\RouteHandler;
use FF\router\Router;
use FF\router\RouterInterface;
use FF\view\TemplateEngine;
use FF\view\View;
use Monolog\Logger;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;
use Throwable;

class Application extends BaseApplication
{
    public RouterInterface $router;
    public LoggerInterface $logger;
    private RequestInterface $request;
    /**
     * @var Closure[]
     */
    private array $middleWares = [];
    /**
     * @param ContainerInterface $container
     * @param RouterInterface $router
     * @param LoggerInterface $logger
     * @param array $config
     */
    public function __construct(
        ContainerInterface $container,
        RouterInterface $router,
        LoggerInterface $logger,
        array $config = []
    ) {
        parent::__construct($container, $config);

        $this->logger = $logger;

        $this->router = $router;
    }

    /**
     * Hide construction from client code
     *
     * @param array $config
     * @return Application
     * @throws Exception
     */
    public static function construct(array $config): Application
    {
        $definitions = [
            LoggerInterface::class => function () use ($config): LoggerInterface {
                return new MonologLogger(new Logger($config['appName'] ?? 'ff-core-app'));
            },
            RouterInterface::class => function () use ($config): RouterInterface {
                return new Router(new FileManager(), $config);
            },
        ];

        if (isset($config['viewPath'])) {
            $definitions[View::class] = function () use ($config) {
                return new View(new TemplateEngine($config['viewPath']));
            };
        }

        if (isset($config['definitions']) && is_array($config['definitions'])) {
            $definitions = array_merge($definitions, $config['definitions']);
        }
        $container = new PHPDIContainer($definitions);

        return new Application(
            $container,
            $container->get(RouterInterface::class),
            $container->get(LoggerInterface::class),
            $config
        );
    }

    /**
     * @param string $path
     * @param Closure $handler
     * @return RouteHandler
     * @throws MethodAlreadyRegistered
     */
    public function get(string $path, Closure $handler): RouteHandler
    {
        return $this->router->get($path, $handler);
    }

    /**
     * @param string $path
     * @param Closure $handler
     * @return RouteHandler
     * @throws MethodAlreadyRegistered
     */
    public function post(string $path, Closure $handler): RouteHandler
    {
        return $this->router->post($path, $handler);
    }

    /**
     * @return int
     */
    public function run(): int
    {
        $this->createRequest();
        try {
            $response = $this->processRequest();

            $response->send();

            return ExitCode::SUCCESS;
        } catch (Exception $e) {
            echo 'Server error: ' . $e->getMessage() . '<br />';
            $this->logger->error($e->getMessage(), $this->request->context());
        }

        return ExitCode::ERROR;
    }

    public function add(Closure $middleWare): self
    {
        $this->middleWares[] = $middleWare;

        return $this;
    }

    private function createRequest(): void
    {
        $this->request = new Request();
    }

    private function processRequest(): ResponseInterface
    {
        $response = $this->createResponse();

        try {
            $this->runHandler($response);
        } catch (UnavailableRequestException $e) {
            $this->logger->error($e->getMessage(), $this->request->context());
            $response->withBody($e->getMessage())->withStatusCode(StatusCode::NOT_FOUND);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage(), $this->request->context());
            $response->withBody($e->getMessage())->withStatusCode(StatusCode::INTERNAL_SERVER_ERROR);
        }

        return $response;
    }

    /**
     * @return ResponseInterface
     */
    private function createResponse(): ResponseInterface
    {
        return new Response();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function runHandler(ResponseInterface $response): void
    {
        [$routeHandler, $args, $controllerName, $action] = $this->router->parseRequest($this->request);

        foreach ($this->middleWares as $middleware) {
            if ($middleware($this->request, $response) === false) {
                return;
            }
        }

        if (is_callable($routeHandler)) {
            $args = array_merge(['request' => $this->request, 'response' => $response], $args);

            $args = $this->injectHandlerArgs($routeHandler->getFunc(), $args);

            $routeHandler($this->request, $response, $args);

            return;
        }

        if (!class_exists($this->config['controllerNamespace'] . $controllerName)) {
            $controllerName = null;
        } else {
            $controllerName = $this->config['controllerNamespace'] . $controllerName;
        }

        $controllerRef = new ReflectionClass( $controllerName);
        $controllersArgs = array_merge(['request' => $this->request, 'response' => $response], $args);
        $controllersArgs = $this->injectActionArgs($controllerRef, $action, $controllersArgs);

        $controller = $this->container->get($controllerName);
        $controller->setRouter($this->router);

        $controller->$action($this->request, $response, ...$controllersArgs);
    }

    private function injectHandlerArgs(Closure $handler, array $args): array
    {
        $result = array_slice(array_values($args), 2);

        $funcRef = new ReflectionFunction($handler);

        $funcParams = $funcRef->getParameters();

        foreach ($funcParams as $funcParam) {
            if (isset($args[$funcParam->getName()])) {
                continue;
            }
            
            $paramType = $funcParam->getType();

            $result[] = $this->container->get($paramType->getName());
        }

        return $result;
    }

    private function injectActionArgs(ReflectionClass $class, string $action, array $args): array
    {
        $result = array_slice(array_values($args), 2);

        $funcRef = $class->getMethod($action);

        $funcParams = $funcRef->getParameters();

        foreach ($funcParams as $funcParam) {
            if (isset($args[$funcParam->getName()])) {
                continue;
            }
            
            $paramType = $funcParam->getType();

            $result[] = $this->container->get($paramType->getName());
        }
        
        return $result;
    }
}
