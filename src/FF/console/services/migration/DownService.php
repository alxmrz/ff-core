<?php

namespace FF\console\services\migration;

use Exception;
use FF\db\DatabaseConnection;
use FF\Migration;

class DownService
{
    public function __construct(private DatabaseConnection $db)
    {
    }

    /**
     * @throws Exception
     */
    public function down()
    {
        $files = $this->getMigrations();
        if (!$files) {
            throw new Exception('Migrations not found');
        }

        foreach (array_reverse($files) as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }
            $migrationName = str_replace('.php', '', $file);
            $className = 'console\migrations\\' . $migrationName;

            $this->getMigrationClass($className)->safeDown();
            $this->db->exec("delete from migration where name='{$migrationName}'");
        }
    }

    protected function getMigrations(): bool|array
    {
        return scandir(__DIR__ . '/../../migrations/');
    }

    protected function getMigrationClass(string $className): Migration
    {
        return new $className($this->getDb());
    }

    public function getDb(): DatabaseConnection
    {
        return $this->db;
    }
}