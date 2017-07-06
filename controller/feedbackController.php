<?php
namespace controller;

use \core\Securety;

class feedbackController
{

    protected $db;

    public function __construct($config)
    {
        $this->db = \core\DatabaseConnection::getInstance($config)->getPDO();
        $this->view = new \core\View();
        $this->actions();
    }

    /**
     *  Генерирует страницу с комментариями
     */
    public function generatePage()
    {
        $data = $this->getComments();
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
        $post = Securety::filterPostInput();
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
