<?php

namespace FF;

use Closure;
use Exception;
use FF\container\PHPDIContainer;
use FF\exceptions\MethodAlreadyRegistered;
use FF\exceptions\UnavailableRequestException;
use FF\http\Request;
use FF\http\Response;
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

    /** @var bool is application running correctly */
    private bool $status = true;

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
    )
    {
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
                return new Router();
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
            [$controllerName, $action, $handler] = $this->router->parseRequest($request);

            try {
                if ($handler !== null) {
                    $handler($request, $response);
                } elseif ($controllerName !== null && $action !== null) {
                    $controller = $this->container->get($controllerName);
                    $controller->setRouter($this->router);

                    $controller->$action($request, $response);
                } else {
                    throw new Exception("No handlers for request found");
                }
            } catch (Throwable $e) {
                $this->logger->error($e->getMessage(), $request->context());
                $response->setBody($e->getMessage());
                $this->status = false;
            }

            $response->send();

            return $this->status ? ExitCode::SUCCESS : ExitCode::ERROR;
        } catch (UnavailableRequestException $e) {
            $this->logger->error('Not available request', $request->context());
            $this->showErrorPage($e, '404 Page not found');
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), $request->context());
            $this->showErrorPage($e);
        }

        return ExitCode::ERROR;
    }


    /**
     * @param Exception $e
     * @param string $additionalInfo
     */
    private function showErrorPage(Exception $e, string $additionalInfo = '')
    {
        $this->status = false;
        $errorMessage = $e->getMessage() . PHP_EOL . $additionalInfo;
        require __DIR__ . '/view/error.php';
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
     * @return Request
     */
    private function createRequest(): Request
    {
        return new Request();
    }

    /**
     * @return Response
     */
    private function createResponse(): Response
    {
        return new Response;
    }
}
