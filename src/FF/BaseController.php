<?php

namespace FF;

use FF\db\DatabaseConnection;
use \PDO;

abstract class BaseController
{
    protected $db;

    /**
     * @return mixed
     */
    public function getDb(): DatabaseConnection
    {
        return $this->db;
    }

    /**
     * @param mixed $db
     */
    public function setDb(DatabaseConnection $db): void
    {
        $this->db = $db;
    }
}
