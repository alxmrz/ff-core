<?php
namespace controller;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class experimentsController
{

    function __construct()
    {
        $this->view = new \core\View();
        $this->view->render('experiments');
    }

    public function index()
    {
        $this->view->render('experiments');
    }

    public function somePage()
    {
        $this->view->render('');
    }

}
