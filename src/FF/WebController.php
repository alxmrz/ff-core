<?php

declare(strict_types=1);

namespace FF;

use FF\router\RouterInterface;
use FF\view\View;

abstract class WebController extends BaseController
{
    public function __construct(protected View $view)
    {
    }

    protected function render(string $template, array $data): string
    {
        return $this->view->render($template, $data);
    }
}
