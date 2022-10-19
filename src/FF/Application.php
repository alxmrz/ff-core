<?php

namespace FF;

use Closure;
use Exception;
use FF\exceptions\MethodAlreadyRegistered;
use FF\exceptions\UnavailableRequestException;
use FF\logger\MonologLogger;
use FF\request\Request;
use FF\router\Router;
use FF\router\RouterInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;

class Application extends BaseApplication
{
    public RouterInterface $router;
    public LoggerInterface $logger;

    private Controller $controller;
    private Request $request;
    private bool $status = true;
    private array $handlers = [];

    /**
     * @param ContainerInterface $container
     * @param array $config
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container, array $config = [])
    {
        $config['mode'] = $config['mode'] ?? 'default';
        parent::__construct($container, $config);

        $this->router = $this->container->get(Router::class);
        $this->request = $this->container->get(Request::class);
        $this->logger = $this->container->get(MonologLogger::class);
    }

    /**
     * @return int
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(): int
    {
        try {
            $result = 0;
            if ($this->config['mode'] === 'default') {
                $this->registerController();
                $action = $this->router->getAction();
                $this->controller->$action();
                $result = ExitCode::SUCCESS;
            } elseif ($this->config['mode'] === 'micro') {
                $requestMethod = $this->request->server('REQUEST_METHOD');
                $requestUri = $this->request->server('REQUEST_URI');
                $handler = $this->handlers[$requestMethod][$requestUri] ?? null;
                if ($handler) {
                    echo $handler();
                    $result = ExitCode::SUCCESS;
                }
            }

            return $this->status ? $result : $this->status;
        } catch (UnavailableRequestException $e) {
            $this->logger->error('Not available request', $this->getContext());
            $this->showErrorPage($e, '404 Page not found');
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), $this->getContext());
            $this->showErrorPage($e);
        }

        return ExitCode::ERROR;
    }

    private function getContext(): array
    {
        return [
            'request' => $this->request->server('REQUEST_URI'),
            'ip' => $this->request->server('REMOTE_ADDR')
        ];
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
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function registerController(): void
    {
        if (!isset($this->config['controllerNamespace'])) {
            throw new Exception('Params controllerNamespace is not specified in app config');
        }
        $server = $this->request->server();
        $this->router->parseUri($server['REQUEST_URI']);
        $pageController = $this->config['controllerNamespace'] . $this->router->getController();

        $this->controller = $this->container->get($pageController);
        $this->controller->setRouter($this->router);
    }

    /**
     * @param string $path
     * @param Closure $handler
     * @return void
     * @throws MethodAlreadyRegistered
     */
    public function get(string $path, Closure $handler): void
    {
        if (!isset($this->handlers["GET"])) {
            $this->handlers["GET"] = [];
        }

        if (isset($this->handlers["GET"][$path])) {
            throw new MethodAlreadyRegistered("Method GET {$path} already registered!");
        }

        $this->handlers["GET"][$path] = $handler;
    }

    public function post(string $path, Closure $handler)
    {
        if (!isset($this->handlers["POST"])) {
            $this->handlers["POST"] = [];
        }

        $this->handlers["POST"][$path] = $handler;
    }
}
