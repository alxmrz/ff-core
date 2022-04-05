<?php

namespace FF\db\repositories;

use FF\db\DatabaseConnection;
use FF\db\models\Migration;

class MigrationRepository
{
    private DatabaseConnection $db;

    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }

    /**
     * @return bool
     */
    public function createTable(): bool
    {
        return $this->db->exec('
        CREATE TABLE IF NOT EXISTS migration(
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR (255) NOT NULL UNIQUE ,
         time INT(4) UNSIGNED
        )') === false ? false : true;
    }

    /**
     * @param string $columnName
     * @return array
     */
    public function getColumnValues(string $columnName): array
    {
        return $this->db->queryColumn('migration', 'name');
    }

    /**
     * @param Migration $migration
     * @return bool
     */
    public function save(Migration $migration): bool
    {
        $sql = "INSERT INTO migration(name, time) values ('{$migration->name}', '{$migration->time}')";

        return $this->db->exec($sql) === false ? false : true;
    }
}
