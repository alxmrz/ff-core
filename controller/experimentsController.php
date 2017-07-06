<?php
namespace controller;

use core\Controller;

/**
 * Контроллер для страницы experiments
 */
class experimentsController extends Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new \core\View();
    }

    public function generatePage()
    {
        $content = $this->view->render('experiments');
        echo $this->view->render('layouts/main',$content);
    }

}
