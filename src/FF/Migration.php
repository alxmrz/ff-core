<?php

namespace FF;

use FF\db\DatabaseConnection;

abstract class Migration
{
    protected DatabaseConnection $db;

    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }

    protected function exec(string $sql)
    {
        $this->db->exec($sql);
    }
}
