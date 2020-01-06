<?php


namespace console\controller;


use core\ConsoleController;
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