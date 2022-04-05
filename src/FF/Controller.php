<?php

namespace FF;

use FF\router\RouterInterface;
use FF\view\View;

abstract class Controller extends BaseController
{
    protected View $view;
    protected RouterInterface $router;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    public function setRouter(RouterInterface $router): void
    {
        $this->router = $router;
    }

    /**
     * @param string $template
     * @param array $data
     * @return string
     */
    protected function render(string $template, array $data): string
    {
        return $this->view->render($template, $data);
    }
}
