<?php


namespace core;


use core\db\DatabaseConnection;

abstract class Migration
{
    protected $db;

    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }

    /**
     * @param string $sql
     */
    protected function exec(string $sql)
    {
        $this->db->exec($sql);
    }
}