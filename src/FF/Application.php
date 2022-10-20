<?php

namespace FF;

use Closure;
use Exception;
use FF\exceptions\MethodAlreadyRegistered;
use FF\exceptions\UnavailableRequestException;
use FF\http\Request;
use FF\http\Response;
use FF\logger\MonologLogger;
use FF\router\Router;
use FF\router\RouterInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class Application extends BaseApplication
{
    public RouterInterface $router;
    public LoggerInterface $logger;

    private Request $request;
    private bool $status = true;

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
        $this->router->setConfig($config);
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
            $response = new Response();

            [$controllerName, $action, $handler] = $this->router->parseRequest($this->request);

            try {
                if ($handler !== null) {
                    $handler($this->request, $response);
                } elseif ($controllerName !== null && $action !== null) {
                    $controller = $this->container->get($controllerName);
                    $controller->setRouter($this->router);

                    $controller->$action($this->request, $response);
                } else {
                    throw new Exception("No handlers for request found");
                }
            } catch (Throwable $e) {
                $this->logger->error($e->getMessage(), $this->getContext());
                $response->setBody($e->getMessage());
                $this->status = false;
            }

            try {
                // TODO: add response headers and code
                echo $response;
            } catch (\Throwable $e) {
                $this->status = false;
                $this->logger->error($e->getMessage(), $this->getContext());
            }

            return $this->status ? ExitCode::SUCCESS : ExitCode::ERROR;
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
}
