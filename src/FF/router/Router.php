<?php
namespace FF\router;

use FF\exceptions\UnavailableRequestException;

class Router implements RouterInterface
{
    private array $requestsExpected = [
        'MainpageController',
        'AuthController'
    ];
    private string $controller;
    private string $action;

    /**
     *
     * @param string $uri
     * @throws UnavailableRequestException
     */
    public function parseUri(string $uri): void
    {
        $this->setUrlParams($uri);
    }

    /**
     * @param $uri
     * @throws UnavailableRequestException
     */
    private function setUrlParams($uri): void
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
            if (str_contains($explodedArray[2], '-')) {
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
     * @return void
     * @throws UnavailableRequestException
     */
    private function isRequestExpected(string $controllerPart): void
    {
        if (in_array($controllerPart, $this->requestsExpected)) {
            return;
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
