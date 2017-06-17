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
        if (isset($post['action'])&&!empty($post['from'])&&!empty($post['comment'])) {
            switch($post['action']) {
                case 'addComment':
                    $this->addComment();
                    break;                 
            }
            header("Location: /feedback/"); 
        } 
    }

    /**
     * @return array Возвращает список комментариев
     */
    protected function getComments()
    {

        $res = $this->db->query("SELECT * from feedback");
        return $res->fetchAll();
    }

    /**
     * Добавляет комментарий в базу
     */
    protected function addComment()
    {
        $post = \core\Securety::filterPostInput();
        $from = $post['from'];
        $comment = $post['comment'];
        $date = "NOW()";
        $query = "INSERT INTO feedback SET `from`=:sfrom,`comment`=:comment,`date`=NOW()";
        $res = $this->db->prepare($query);
        $res->bindValue(':sfrom',$from);
        $res->bindValue(':comment',$comment);
        $res->execute();
    }

}
