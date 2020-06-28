<?php

namespace core;

use core\router\Router;
use \core\view\View;

abstract class Controller extends BaseController
{
    /**
     * @var View
     */
    protected View $view;
    protected Router $router;

    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * @param Router $router
     */
    public function setRouter(Router $router): void
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
