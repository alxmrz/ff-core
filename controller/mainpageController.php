<?php
namespace controller;

use core\Controller;

class mainpageController extends Controller
{
    /**
     * Экземпляр класса View
     * @var \core\View
     */
    protected $view;

    public function __construct()
    {
        $this->view = new \core\View();
    }

    /**
     * Генерирует всю страницу целиком
     */
    public function generatePage()
    {
        $content = $this->view->render('mainpage');
        echo $this->view->render('layouts/main',$content);
    }

}
