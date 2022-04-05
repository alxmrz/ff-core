<?php

namespace FF;

use Exception;
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

    /**
     * @param ContainerInterface $container
     * @param array $config
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container, array $config = [])
    {
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
        $context = [
            'request' => $this->request->server('REQUEST_URI'),
            'ip' => $this->request->server('REMOTE_ADDR')
        ];

        try {
            $this->registerController();
            $action = $this->router->getAction();

            return $this->status ? $this->controller->$action() : $this->status;
        } catch (UnavailableRequestException $e) {
            $this->logger->error('Not available request', $context);
            $this->showErrorPage($e, '404 Page not found');
            exit();
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), $context);
            $this->showErrorPage($e);
            exit();
        }
    }

    /**
     * @param Exception $e
     * @param string $additionalInfo
     */
    private function showErrorPage(Exception $e, string $additionalInfo = '')
    {
        $this->status = false;
        $errorMessage = $e->getMessage() . PHP_EOL . $additionalInfo;
        require __DIR__ . '/../view/error.php';
    }

    /**
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function registerController(): void
    {
        $server = $this->request->server();
        $this->router->parseUri($server['REQUEST_URI']);
        $pageController = 'controller\\' . $this->router->getController();

        $this->controller = $this->container->get($pageController);
        $this->controller->setRouter($this->router);
    }
}
