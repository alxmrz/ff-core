<?php


namespace console\services\migration;


use core\db\DatabaseConnection;
use core\db\models\Migration;
use core\db\repositories\MigrationRepository;
use core\exceptions\MigrationApplymentNotFixed;
use core\exceptions\TableNotCreated;
use core\exceptions\UnavailablePath;
use core\libraries\DateTime;
use core\libraries\FileManager;
use core\MigrationFactory;

class UpService
{
    private const MIGRATIONS_PATH = __DIR__ . '/../../migrations/';
    private DatabaseConnection $db;
    private FileManager $fileManager;
    private DateTime $now;
    private MigrationRepository $migrationRepository;
    private MigrationFactory $migrationFactory;

    public function __construct(
        DatabaseConnection $db,
        FileManager $fileManager,
        DateTime $now,
        MigrationRepository $migrationRepository,
        MigrationFactory $migrationFactory)
    {
        $this->db = $db;
        $this->fileManager = $fileManager;
        $this->now = $now;
        $this->migrationRepository = $migrationRepository;
        $this->migrationFactory = $migrationFactory;
    }

    /**
     * @return string
     * @throws TableNotCreated|MigrationApplymentNotFixed
     */
    public function up()
    {
        if (!$this->migrationRepository->createTable()) {
            throw new TableNotCreated('Unable to create Migration table');
        }

        $migrations = $this->getNewMigrations();
        if (empty($migrations)) {
            return 'No new migrations found';
        }

        foreach ($migrations as $migration) {
            $this->applyMigration($migration);
        }
    }

    /**
     * @return array
     */
    private function getNewMigrations(): array
    {
        try {
            $migrations = $this->fileManager->scanDir(self::MIGRATIONS_PATH);
            $migrations = array_diff($migrations, ['.', '..']);
            $migrations = $this->removeEvaluatedMigrations($migrations);
        } catch (UnavailablePath $e) {
            $migrations = [];
        }

        return $migrations;
    }

    /**
     * @param array $migrations
     * @return array
     */
    private function removeEvaluatedMigrations(array $migrations): array
    {
        $appliedMigrations = $this->migrationRepository->getColumnValues('name');

        return array_diff($migrations, $appliedMigrations);
    }

    /**
     * @param $file
     * @throws MigrationApplymentNotFixed
     * @throws \Exception
     */
    private function applyMigration($file): void
    {
        $migrationName = str_replace('.php', '', $file);
        $className = 'console\migrations\\' . $migrationName;

        try {
            $this->migrationFactory->createByClassName($className, $this->db)->safeUp();
        } catch (\Throwable $e) {
            throw new \Exception("Migration up error for file {$file}: {$e->getMessage()}");
        }

        $migration = new Migration();
        $migration->name = $migrationName;
        $migration->time = $this->now->getTimestamp();

        if (!$this->migrationRepository->save($migration)) {
            throw new MigrationApplymentNotFixed("Can not to fix migration {$file}");
        }
    }
}