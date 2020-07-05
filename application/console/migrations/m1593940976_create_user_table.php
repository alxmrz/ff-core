<?php


namespace console\migrations;


use core\Migration;

class m1593940976_create_user_table extends Migration
{

    public function safeUp()
    {
        $sql = "CREATE table user(
     id INT AUTO_INCREMENT PRIMARY KEY,
     login VARCHAR(64) NOT NULL UNIQUE,
     password VARCHAR (32) NOT NULL);";

        $this->exec($sql);
    }

    public function safeDown()
    {
        $sql = "DROP table menu;";

        $this->exec($sql);
    }
}