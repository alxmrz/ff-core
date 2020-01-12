<?php

namespace core;

use core\db\DatabaseConnection;

abstract class BaseController
{
    protected $db;

    /**
     * @return mixed
     */
    public function getDb()
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
