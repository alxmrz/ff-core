<?php
namespace controller;

class mainpageController
{

    function __construct()
    {
        $this->view = new \core\View();
        $this->view->render('mainpage');
    }

    public function index()
    {
        $this->view->render('mainpage');
    }

}
