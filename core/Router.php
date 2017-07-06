<?php
namespace core;

/**
 * Description of router
 */
class Router
{
    protected $controller;
    public function __construct($config)
    {
        try {
            $urlParams = explode('/', ($_SERVER['REQUEST_URI']));

            if (!empty($urlParams[1])) {
                $pageController = 'controller\\' . $urlParams[1] . 'Controller';
            } else {
                $pageController = 'controller\mainpageController';
            }

            $this->controller = new $pageController($config);

        } catch(Exception $e) {

            $errorMessage = $e->getMessage();
            require '/view/error.php';
            exit();
        }

    }

    public function startApplication()
    {
        return $this->controller->generatePage();
    }

}
