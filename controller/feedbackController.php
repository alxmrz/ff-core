<?php
namespace controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class feedbackController
{

    function __construct()
    {
        $this->view = new \core\View();
        $this->view->render('feedback');
    }

    public function index()
    {
        $this->view->render('feedback');
    }

    public function somePage()
    {
        $this->view->render('');
    }

}
