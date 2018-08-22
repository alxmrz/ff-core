<?php

namespace core;

use core\exceptions\UnavailableRequestException;
use core\logger\MonologLogger;
use core\request\Request;
use core\router\Router;
use phpDocumentor\Reflection\Types\Array_;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class Application extends BaseApplication
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
     * @var bool
     */
    private $status = true;

    /**
     * @var Router
     */
    public $router;

    /**
     * @var LoggerInterface
     */
    public $logger;

    /**
     * @param ContainerInterface $container
     * @param array $config
     */
    public function __construct(ContainerInterface $container, array $config = [])
    {
        parent::__construct($container, $config);

        $this->router  = $this->container->get(Router::class);
        $this->request = $this->container->get(Request::class);
        $this->logger  = $this->container->get(MonologLogger::class);
    }

    /**
     * @return int
     */
    public function run()
    {
        $requestUri = $this->request->server('REQUEST_URI');
        $remoteAddr = $this->request->server('REMOTE_ADDR');
        $context = ['request' => $requestUri, 'ip' => $remoteAddr];
        try {
            $this->registerController();
        } catch (UnavailableRequestException $unex) {
            $this->logger->error('Not available request', $context);
            $this->showErrorPage($unex, '404 Page not found');
        } catch (\Exception $ex) {
            $this->logger->error($ex->getMessage(), $context);
            $this->showErrorPage($ex);
        }
        $action = $this->router->getAction();

        return $this->status ? $this->controller->$action() : $this->status;
    }

    /**
     * @param \Exception $ex
     * @param string $additionInfo
     */
    private function showErrorPage(\Exception $ex, string $additionInfo = '')
    {
        $this->status = false;
        $errorMessage = $ex->getMessage();
        require '../view/error.php';
    }

    private function registerController(): void
    {
        $server = $this->request->server();
        $this->router->parseUri($server['REQUEST_URI']);
        $pageController = 'controller\\' . $this->router->getController();

        $this->controller = $this->container->get($pageController);
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
