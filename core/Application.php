<?php

namespace core;

use core\exceptions\UnavailableRequestException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Application implements BaseApplication
{
    /*
     * @var \core\Controller 
     */

    private $controller;

    /**
     * @var \core\HttpDemultiplexer
     */
    private $httpDemultiplexer;

    /**
     * @var int 
     */
    private $isApplicationRunnig = 1;

    /**
     * @var core\Router
     */
    public $router;

    /**
     * @return int
     */
    public function run()
    {
        return $this->isApplicationRunnig === 1 ? $this->controller->generatePage() : $this->isApplicationRunnig;
    }

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->init($config);
    }

    /**
     * @param \Exception $ex
     * @param string $additionInfo
     */
    private function showErrorPage(\Exception $ex, string $additionInfo = '')
    {
        $this->isApplicationRunnig = 0;
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
        $server = $this->httpDemultiplexer->getServer();
        $this->router->parseUri($server['REQUEST_URI']);
        $pageController = 'controller\\' . $this->router->getController();

        $this->controller = new $pageController($config);
    }

    /**
     * @return void
     */
    private function registerLogger()
    {
        $logger = new Logger('Request_logger');

        $logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/my_app.log', Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());

        $this->logger = $logger;
    }

    /**
     * @param array $config
     */
    private function init(array $config)
    {
        $this->router = new Router();
        $this->httpDemultiplexer = new HttpDemultiplexer;
            
        $server = $this->httpDemultiplexer->getServer();
        $requestUri = $server['REQUEST_URI'];
        $remoteAddr = isset($server['REMOTE_ADDR']) ?? '';
        try {
            $this->registerLogger();
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
     * @return HttpDemultiplexer
     */
    public function getHttpDemultiplexer(): HttpDemultiplexer
    {
        return $this->httpDemultiplexer;
    }

    /**
     * @return \core\Controller
     */
    public function getController(): \core\Controller
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getPageToRender(): string
    {
        return $this->pageToRender;
    }

}
