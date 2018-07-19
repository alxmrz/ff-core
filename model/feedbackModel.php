<?php

namespace model;

use core\Model;
use core\DatabaseConnection;
use core\Security;

class feedbackModel extends Model
{

  protected $db;

  public function __construct($config)
  {
    $this->db = DatabaseConnection::getInstance($config)->getPDO();
  }

  /**
   * @return array Возвращает список комментариев
   */
  public function getComments()
  {

    $res = $this->db->query("SELECT * from feedback");
    return $res->fetchAll();
  }

  /**
   * Добавляет комментарий в базу
   */
  public function addComment()
  {
    $post = Security::filterPostInput();
    $from = $post['from'];
    $comment = $post['comment'];
    $date = "NOW()";
    $query = "INSERT INTO feedback SET `from`=:sfrom,`comment`=:comment,`date`=NOW()";
    $res = $this->db->prepare($query);
    $res->bindValue(':sfrom', $from);
    $res->bindValue(':comment', $comment);
    $res->execute();
  }

}
