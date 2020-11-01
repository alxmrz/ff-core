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
        'AuthController'
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
     * @param $uri
     * @throws UnavailableRequestException
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
            if (strstr($explodedArray[2], '-')) {
                $actionParts = explode('-', $explodedArray[2]);
                foreach($actionParts as &$actionPart) {
                    $actionPart = ucfirst($actionPart);
                }
                $actionPart = implode($actionParts);
            } else {
                $actionPart = ucfirst($explodedArray[2]);
            }

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
