<?php
namespace controller;

use core\Controller;
use core\Securety;
use core\View;
use model\feedbackModel;


class feedbackController extends Controller
{
    protected $model;

    public function __construct($config)
    {
        $this->model = new feedbackModel($config);
        $this->view = new View();
        $this->actions($config);
    }

    /**
     *  Генерирует страницу с комментариями
     */
    public function generatePage()
    {
        $data = $this->model->getComments();
        $content = $this->view->render('feedback', $data);
        echo $this->view->render('layouts/main',$content);
    }
    /**
     * Выполняет инструкции в зависимости от типа действия перед 
     * отображением шаблона
     */
    protected function actions()
    {
        $post = Securety::filterPostInput();
        if (isset($post['action'])&&!empty($post['from'])&&!empty($post['comment'])) {
            switch($post['action']) {
                case 'addComment':
                    $this->model->addComment();
                    break;                 
            }
            header("Location: /feedback/"); 
        } 
    }



}
