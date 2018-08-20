<?php

namespace core\router;

use core\exceptions\UnavailableRequestException;

class Router
{


    /**
     * @var array
     */
    private $requestsExpected = array(
        'MainpageController',
    );
    private $controller;

    /**
     *
     * @param string $uri
     * @return array
     */
    public function parseUri($uri)
    {
        $this->setUrlParams($uri);
    }

    /**
     * @return void
     */
    private function setUrlParams($uri)
    {
        $explodedArray = explode('/', ($uri));

        if (empty($explodedArray[1])) {
            $this->controller = 'MainpageController';
        } else {
            $this->controller = ucfirst($explodedArray[1]) . 'Controller';
        }

        if (empty($explodedArray[2])) {
            $this->action = 'actionIndex';
        } else {
            $actionPart = ucfirst($explodedArray[2]);
            $this->action = "action{$actionPart}";
        }

        $this->isRequestExpected($this->controller);
    }

    /**
     * @param string $controllerPart
     * @return bool
     * @throws UnavailableRequestException
     */
    private function isRequestExpected(string $controllerPart): bool
    {
        if (in_array($controllerPart, $this->requestsExpected)) {
            return true;
        }
        throw new UnavailableRequestException("REQUEST {$this->controller} IS NOT AVAILIBLE");
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }


}
