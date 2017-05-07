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
    protected function actions() {
        
    }

}
