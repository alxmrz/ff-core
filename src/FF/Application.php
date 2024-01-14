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
    public RouterInterface $router;
    public LoggerInterface $logger;

    /**
     * @param ContainerInterface $container
     * @param RouterInterface $router
     * @param LoggerInterface $logger
     * @param array $config
     */
    public function __construct(
        ContainerInterface $container,
        RouterInterface    $router,
        LoggerInterface    $logger,
        array              $config = []
    ) {
        parent::__construct($container, $config);

        $this->logger = $logger;

        $this->router = $router;
        $this->router->setConfig($config);
    }

    /**
     * Hide construction from client code
     *
     * @param array $config
     * @return static
     * @throws Exception
     */
    public static function construct(array $config): static
    {
        $definitions = [
            LoggerInterface::class => function () use ($config) {
                return new MonologLogger(new Logger($config['appName'] ?? 'ff-core-app'));
            },
            RouterInterface::class => function () {
                return new Router(new FileManager());
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

        return new static(
            $container,
            $container->get(RouterInterface::class),
            $container->get(LoggerInterface::class),
            $config
        );
    }

    /**
     * @return int
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(): int
    {
        $request = $this->createRequest();
        $response = $this->createResponse();

        try {
            [$handler, $controllerName, $action, $args] = $this->router->parseRequest($request);
            try {
                if (is_callable($handler)) {
                    $handler($request, $response, ...$args);
                } else {
                    $controller = $this->container->get($controllerName);
                    $controller->setRouter($this->router);

                    $controller->$action($request, $response);
                }
            } catch (UnavailableRequestException $e) {
                $this->logger->error($e->getMessage(), $request->context());
                $response->withBody($e->getMessage())->withStatusCode(StatusCode::NOT_FOUND);
            } catch (Throwable $e) {
                $this->logger->error($e->getMessage(), $request->context());
                $response->withBody($e->getMessage())->withStatusCode(StatusCode::INTERNAL_SERVER_ERROR);
            }

            $response->send();

            return ExitCode::SUCCESS;
        } catch (Exception $e) {
            echo 'Server error: ' . $e->getMessage() . '<br />';
            $this->logger->error($e->getMessage(), $request->context());
        }

        return ExitCode::ERROR;
    }

    /**
     * @param string $path
     * @param Closure $handler
     * @return void
     * @throws MethodAlreadyRegistered
     */
    public function get(string $path, Closure $handler): void
    {
        $this->router->get($path, $handler);
    }

    /**
     * @param string $path
     * @param Closure $handler
     * @throws MethodAlreadyRegistered
     */
    public function post(string $path, Closure $handler): void
    {
        $this->router->post($path, $handler);
    }

    /**
     * @return RequestInterface
     */
    private function createRequest(): RequestInterface
    {
        return new Request();
    }

    /**
     * @return ResponseInterface
     */
    private function createResponse(): ResponseInterface
    {
        return new Response();
    }
}
