<?php


namespace FF\console\controller;


use console\services\migration\CreateService;
use console\services\migration\DownService;
use console\services\migration\UpService;
use FF\ConsoleController;
use FF\db\repositories\MigrationRepository;
use FF\libraries\DateTime;
use FF\libraries\FileManager;
use FF\MigrationFactory;

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
            $upService = new UpService(
                $this->getDb(),
                new FileManager(),
                new DateTime(),
                new MigrationRepository($this->getDb()),
                new MigrationFactory()
            );
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