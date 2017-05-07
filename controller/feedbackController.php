<?php

namespace controller;

class feedbackController
{

    protected $db;

    function __construct()
    {
        $this->db = \core\DatabaseConnection::getInstance()->getPDO();
        $this->view = new \core\View();
        $this->actions();
        $data = $this->getComments();
        $this->view->render('feedback', $data);
    }

    /**
     * Выполняет инструкции в зависимости от типа действия перед 
     * отображением шаблона
     */
    protected function actions()
    {
        $post = \core\Securety::filterPostInput();
        if (isset($post['action'])&&isset($post['name'])&&isset($post['comment'])) {
            switch($post['action']) {
                case 'addComment':
                    $this->addComment();
                    break;                 
            }
            header("Location: /feedback/"); 
        } 
    }

    protected function getComments()
    {

        $res = $this->db->query("SELECT * from feedback");
        return $res->fetchAll();
    }

    protected function addComment()
    {
        $post = \core\Securety::filterPostInput();
        $from = $post['from'];
        $comment = $post['comment'];
        $date = "NOW()";
        $query = "INSERT INTO feedback SET `from`='{$from}',`comment`='{$comment}',`date`={$date}";
        $res = $this->db->exec($query);
    }

}
