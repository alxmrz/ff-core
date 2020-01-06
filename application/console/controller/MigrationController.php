<?php


namespace console\controller;


use core\ConsoleController;
use core\container\PHPDIContainer;
use core\exceptions\MigrationNameNotProvidedException;

class MigrationController extends ConsoleController
{
    public function actionCreate(string $migrationName)
    {
        if (empty($migrationName))  {
            throw new MigrationNameNotProvidedException('Exception name not provided!');
        }

        $migrationClassName = 'm' . time() . '_' . $migrationName;
        $templateContent = $this->getTemplateContent();
        $replacedContent = str_replace('MigrationClassTemplate', $migrationClassName, $templateContent);
        $migrationFileName = $migrationClassName . '.php';
        $this->createMigrationFile($migrationFileName, $replacedContent);
    }

    public function actionRun()
    {
        $files = $this->getMigrations();
        if (!$files) {
            throw new \Exception('Migrations not found');
        }

        foreach ($files as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }
            $className = 'console\migrations\\' . str_replace('.php', '', $file);

            $this->getMigrationClass($className)->safeUp();
        }
    }

    protected function getMigrations()
    {
        return scandir(__DIR__ . '/../migrations/');
    }

    protected function getMigrationClass($className)
    {
        return new $className;
    }

    protected function getTemplateContent()
    {
        return file_get_contents(__DIR__ . '/../../core/MigrationClassTemplate.php');
    }

    protected function createMigrationFile(string $fileName, $fileContent)
    {
        //TODO: test the condition
        if (!is_dir(__DIR__ . '/../migrations/')) {
            mkdir(__DIR__ . '/../migrations/');
        }

        file_put_contents(__DIR__ . '/../migrations/' . $fileName, $fileContent);
    }


}