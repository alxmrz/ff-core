<?php

namespace core;

use core\exceptions\UnavailableRequestException;
use core\logger\MonologLogger;
use core\request\Request;
use core\router\Router;
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
     * @return int
     */
    public function run()
    {
        $action = $this->router->getAction();
        return $this->status === 1 ? $this->controller->$action() : $this->status;
    }

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->init($config);
    }

    /**
     * @param array $config
     */
    private function init(array $config)
    {
        $this->router = new Router();
        $this->request = new Request;
        $this->logger = new MonologLogger();
        $server = $this->request->server();
        $requestUri = $server['REQUEST_URI'];
        $remoteAddr = isset($server['REMOTE_ADDR']) ?? '';
        try {
            $this->logger->info('Registered request', array('request' => $requestUri, 'ip' => $remoteAddr));
            $this->registerController($config);
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
        $additionInfo = $additionInfo;
        $errorMessage = $ex->getMessage();
        require '../view/error.php';
    }

    /**
     * @param array $config
     * @return void
     */
    private function registerController(array $config = [])
    {
        $server = $this->request->server();
        $this->router->parseUri($server['REQUEST_URI']);
        $pageController = 'controller\\' . $this->router->getController();

        $this->controller = new $pageController($config);
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
