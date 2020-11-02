<?php


namespace FF\console\services\migration;


use FF\db\DatabaseConnection;

class DownService
{
    private DatabaseConnection $db;

    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }

    public function down()
    {
        $files = $this->getMigrations();
        if (!$files) {
            throw new \Exception('Migrations not found');
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

    protected function getMigrations()
    {
        return scandir(__DIR__ . '/../../migrations/');
    }

    protected function getMigrationClass($className)
    {
        return new $className($this->getDb());
    }

    /**
     * @return DatabaseConnection
     */
    public function getDb(): DatabaseConnection
    {
        return $this->db;
    }
}