<?php
namespace core;
/**
 * Description of router
 *
 * @author Alexandr
 */
class Router
{

    public function __construct()
    {
        $urlParams = explode('/', ($_SERVER['REQUEST_URI']));
        if (!empty($urlParams[1])) {
            $pageController = 'controller\\' . $urlParams[1] . 'Controller';
        } else {
            $pageController = 'controller\mainpageController';
        }
        
        $controller = new $pageController;
        
    }

}
