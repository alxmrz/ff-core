<?php


namespace console\migrations;


use core\db\DatabaseConnection;

class m1578819348_create_menu_table
{
    protected $db;

    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }

    public function safeUp()
    {
        $sql = "CREATE table menu(
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR (32) NOT NULL);";
        
        $this->db->exec($sql);
    }

    public function safeDown()
    {
        $sql = "DROP table menu;";

        $this->db->exec($sql);
    }
}