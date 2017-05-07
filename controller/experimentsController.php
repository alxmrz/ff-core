<?php
namespace controller;

/**
 * Контроллер для страницы experiments
 */
class experimentsController
{

    public function __construct()
    {
        $this->view = new \core\View();
        $this->view->render('experiments');
    }

    public function index()
    {
        $this->view->render('experiments');
    }

}
