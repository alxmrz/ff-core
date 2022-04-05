<?php

namespace FF;

use FF\db\DatabaseConnection;

abstract class BaseController
{
    protected DatabaseConnection $db;

    /**
     * @return DatabaseConnection
     */
    public function getDb(): DatabaseConnection
    {
        return $this->db;
    }

    /**
     * @param DatabaseConnection $db
     */
    public function setDb(DatabaseConnection $db): void
    {
        $this->db = $db;
    }
}
