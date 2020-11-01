<?php


namespace console\controller;


use console\services\migration\CreateService;
use console\services\migration\DownService;
use console\services\migration\UpService;
use core\ConsoleController;
use core\libraries\DateTime;
use core\libraries\FileManager;

class MigrationController extends ConsoleController
{
    public function actionCreate(string $migrationName)
    {
        try {
            $createService = new CreateService(new DateTime(), new FileManager());
            return $createService->create($migrationName);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    public function actionUp()
    {
        try {
            $upService = new UpService($this->getDb());
            $upService->up();
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    public function actionDown()
    {
        try {
            $downService = new DownService($this->getDb());
            $downService->down();
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }
}