<?php


namespace console\migrations;


use core\db\DatabaseConnection;

class MigrationClassTemplate
{
    protected $db;

    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }

    public function safeUp()
    {

    }

    public function safeDown()
    {

    }
}