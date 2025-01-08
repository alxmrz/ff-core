<?php

declare(strict_types=1);

namespace FF;

use FF\router\RouterInterface;
use FF\view\View;

abstract class WebController extends BaseController
{
    protected View $view;

    public function __construct(View $view)
    {
        $this->view = $view;
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
