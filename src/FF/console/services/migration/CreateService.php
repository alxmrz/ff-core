<?php


namespace FF\console\services\migration;


use FF\exceptions\FileNotCreated;
use FF\exceptions\MigrationNameNotProvidedException;
use FF\exceptions\UnavailablePath;
use FF\libraries\DateTime;
use FF\libraries\FileManager;

class CreateService
{
    private string $migrationTemplatePath = __DIR__ . '/../../../core/MigrationClassTemplate.php';

    public function __construct(
        private DateTime $now,
        private FileManager $fileManager
    ){}

    /**
     * Creates migration file with the specified name
     *
     * @param string $migrationName
     * @return bool
     * @throws MigrationNameNotProvidedException
     * @throws UnavailablePath
     * @throws FileNotCreated
     */
    public function create(string $migrationName): bool
    {
        if (empty($migrationName)) {
            throw new MigrationNameNotProvidedException('Exception name not provided!');
        }

        $migrationClassName = $this->generateMigrationClassName($migrationName);
        $migrationFileName = $migrationClassName . '.php';

        $replacedContent = $this->getCurrentMigrationTemplateContent($migrationClassName);

        return $this->fileManager->createFile(__DIR__ . "/../../migrations/$migrationFileName", $replacedContent);
    }

    /**
     * @param string $migrationName
     * @return string
     */
    public function generateMigrationClassName(string $migrationName): string
    {
        return 'm' . $this->now->getTimestamp() . '_' . $migrationName;
    }

    /**
     * @param string $migrationClassName
     * @return string
     */
    public function getCurrentMigrationTemplateContent(string $migrationClassName): string
    {
        $templateContent = $this->fileManager->getContent($this->migrationTemplatePath);

        return str_replace('MigrationClassTemplate', $migrationClassName, $templateContent);
    }
}