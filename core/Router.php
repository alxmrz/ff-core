<?php

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
            $pageController = "{$urlParams[1]}Controller";
        } else {
            $pageController = 'mainpageController';
        }
        $controller = new $pageController;
    }

}
