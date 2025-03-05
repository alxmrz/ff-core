<?php

declare(strict_types=1);

namespace FF;

use Closure;
use Exception;
use FF\container\PHPDIContainer;
use FF\exceptions\ControllerNotFound;
use FF\exceptions\MethodAlreadyRegistered;
use FF\exceptions\UnavailableRequestException;
use FF\http\Request;
use FF\http\RequestInterface;
use FF\http\Response;
use FF\http\ResponseInterface;
use FF\http\StatusCode;
use FF\logger\MonologLogger;
use FF\ReflectionArgsInjector;
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
use Throwable;

class Application extends BaseApplication
{
    private RequestInterface $request;
    /**
     * @var Closure[]
     */
    private array $middleWares = [];

    public function __construct(
        ContainerInterface      $container,
        private RouterInterface $router,
        private LoggerInterface $logger,
        array                   $config = []
    )
    {
        parent::__construct($container, $config);
    }

    /**
     * Hide construction from client code
     *
     * @throws Exception
     */
    public static function construct(array $config): Application
    {
        $definitions = [
            LoggerInterface::class => fn(): LoggerInterface => new MonologLogger(new Logger($config['appName'] ?? 'ff-core-app')),
            RouterInterface::class => fn(): RouterInterface => new Router($config),
        ];

        if (isset($config['viewPath'])) {
            $definitions[View::class] = (fn() => new View(new TemplateEngine($config['viewPath'])));
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
     * @throws MethodAlreadyRegistered
     */
    public function get(string $path, Closure $handler): RouteHandler
    {
        return $this->router->get($path, $handler);
    }

    /**
     * @throws MethodAlreadyRegistered
     */
    public function post(string $path, Closure $handler): RouteHandler
    {
        return $this->router->post($path, $handler);
    }

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

        if (!$this->runMiddlewares($response)) {
            return;
        }

        $argsInjector = new ReflectionArgsInjector($this->container);

        $args = array_merge(['request' => $this->request, 'response' => $response], $args);

        if (is_callable($routeHandler)) {
            $routeHandler(
                $this->request,
                $response,
                $argsInjector->injectHandlerArgs($routeHandler->getFunc(), $args)
            );

            return;
        }

        $controllerName = $this->config['controllerNamespace'] . $controllerName;

        try {
            $args = $argsInjector->injectActionArgs($controllerName, $action, $args);
        } catch (ControllerNotFound $e) {
            throw new UnavailableRequestException($this->request, $e);
        }

        $controller = $this->container->get($controllerName);
        $controller->setRouter($this->router);

        $controller->$action($this->request, $response, ...$args);
    }

    private function runMiddlewares(ResponseInterface $response): bool
    {
        foreach ($this->middleWares as $middleware) {
            if ($middleware($this->request, $response) === false) {
                return false;
            }
        }

        return true;
    }
}
