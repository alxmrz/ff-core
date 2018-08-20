<?php

namespace core;

use \core\view\View;

abstract class Controller
{
    /**
     * @var View
     */
    protected $view;

    public function __construct()
    {
        $this->view = new View();
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
