<?php
namespace controller;

/**
 * Description of skillsController
 *
 * @author Alexandr
 */
class skillsController
{

    public function __construct()
    {
        $this->view = new \core\View();
        $this->view->render('skills');
    }

    /**
     * Генерирует страницу
     */
    public function generatePage()
    {
        $content = $this->view->render('skills');
        echo $this->view->render('layouts/main',$content);
    }
}
