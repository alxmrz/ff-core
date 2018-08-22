<?php

namespace core;

use core\container\PHPDIContainer;
use core\exceptions\UnavailableRequestException;
use core\logger\MonologLogger;
use core\request\Request;
use core\router\Router;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class Application implements BaseApplication
{
    /*
     * @var \core\Controller
     */
    private $controller;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var int
     */
    private $status = 1;

    /**
     * @var Router
     */
    public $router;

    /**
     * @var LoggerInterface
     */
    public $logger;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var array
     */
    private $config;
    /**
     * @return int
     */
    public function run()
    {
        $action = $this->router->getAction();
        return $this->status === 1 ? $this->controller->$action() : $this->status;
    }

    /**
     * @param ContainerInterface $container
     * @param array $config
     */
    public function __construct(ContainerInterface $container, array $config = [])
    {
        $this->container = $container;
        $this->config = $config;
        $this->init();
    }

    private function init()
    {
        $this->router  = $this->container->get(Router::class);
        $this->request = $this->container->get(Request::class);
        $this->logger  = $this->container->get(MonologLogger::class);

        $server = $this->request->server();
        $requestUri = $server['REQUEST_URI'];
        $remoteAddr = isset($server['REMOTE_ADDR']) ?? '';
        try {
            $this->logger->info('Registered request', array('request' => $requestUri, 'ip' => $remoteAddr));
            $this->registerController();
        } catch (UnavailableRequestException $unex) {
            $this->logger->info('Not available request', array('request' => $requestUri, 'ip' => $remoteAddr));
            $this->showErrorPage($unex, '404 Страница не найдена');
        } catch (\Exception $ex) {
            $this->logger->info('Unexpected exception', array('message' => $ex->getMessage(), 'ip' => $remoteAddr));
            $this->showErrorPage($ex);
        }
    }

    /**
     * @param \Exception $ex
     * @param string $additionInfo
     */
    private function showErrorPage(\Exception $ex, string $additionInfo = '')
    {
        $this->status = 0;
        $errorMessage = $ex->getMessage();
        require '../view/error.php';
    }

    private function registerController(): void
    {
        $server = $this->request->server();
        $this->router->parseUri($server['REQUEST_URI']);
        $pageController = 'controller\\' . $this->router->getController();

        $this->controller = new $pageController($this->config);
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return \core\Controller
     */
    public function getController(): \core\Controller
    {
        return $this->controller;
    }
}
