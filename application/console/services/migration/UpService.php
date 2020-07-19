<?php


namespace console\services\migration;


use core\db\DatabaseConnection;

class UpService
{
    private DatabaseConnection $db;

    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }

    public function up()
    {
        $files = $this->getMigrations();
        if (!$files) {
            throw new \Exception('Migrations not found');
        }

        $this->createMigrationTable();
        $files = array_diff($files, ['.', '..']);
        $files = $this->removeEvaluated($files);
        if (empty($files)) {
            throw new \Exception('No new migrations found');
        }
        foreach ($files as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }
            $className = 'console\migrations\\' . str_replace('.php', '', $file);

            $this->getMigrationClass($className)->safeUp();
            $this->addCompletedMigration($file);
        }
    }

    protected function getMigrations()
    {
        $path = __DIR__ . '/../../migrations/';
        if (!is_dir($path)) {
            mkdir($path);
            return [];
        }

        return scandir($path);
    }

    protected function getMigrationClass($className)
    {
        return new $className($this->getDb());
    }

    private function createMigrationTable()
    {
        $this->getDb()->exec('CREATE TABLE IF NOT EXISTS migration(
     id INT AUTO_INCREMENT PRIMARY KEY,
     name VARCHAR (255) NOT NULL UNIQUE ,
     time INT(4) UNSIGNED)');
    }

    private function addCompletedMigration(string $file)
    {
        $now = time();
        $this->getDb()->exec("INSERT INTO migration(name, time) values ('{$file}', '{$now}')");
    }

    private function removeEvaluated(array $files)
    {
        $migrations = $this->getDb()->queryColumn('migration', 'name');

        return array_diff($files, $migrations);
    }

    /**
     * @return DatabaseConnection
     */
    public function getDb(): DatabaseConnection
    {
        return $this->db;
    }
}