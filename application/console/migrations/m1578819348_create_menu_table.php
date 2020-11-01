<?php


namespace console\migrations;


use core\Migration;

class m1578819348_create_menu_table extends Migration
{
    public function safeUp()
    {
        $sql = "CREATE table menu(
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR (32) NOT NULL);";

        $this->exec($sql);
    }

    public function safeDown()
    {
        $sql = "DROP table menu;";

        $this->exec($sql);
    }
}