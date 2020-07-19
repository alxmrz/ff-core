<?php


namespace console\services\migration;


use core\db\DatabaseConnection;

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
            $className = 'console\migrations\\' . str_replace('.php', '', $file);

            $this->getMigrationClass($className)->safeDown();
        }
    }

    protected function getMigrations()
    {
        return scandir(__DIR__ . '/../migrations/');
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