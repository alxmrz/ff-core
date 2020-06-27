<?php


use console\controller\MigrationController;
use core\db\DatabaseConnection;
use core\exceptions\MigrationNameNotProvidedException;

class MigrationControllerTest extends CustomTestCase
{
    public function testActionCreate_WhenActionIsCalledThenMigrationFileIsCreated()
    {
        $migrationController = $this->createMigrationController();
        $migrationController->actionCreate('fileName');

        $this->assertStringMatchesFormat('m%d_fileName.php', $migrationController->migrationName);
    }

    public function testActionCreate_WhenMigrationNameIsNotSetOrEmptyThenThrowException()
    {
        $migrationController = $this->createMigrationController();
        $this->expectException(MigrationNameNotProvidedException::class);

        $migrationController->actionCreate('');
    }

    public function testActionCreate_WhenMethodCalledThenCreateMigrationFileTemplateWillBeUsed()
    {
        $migrationController = $this->createMigrationController();
        $migrationController->actionCreate('create_migration_table');

        $this->assertStringMatchesFormat('class m%d_create_migration_table', $migrationController->migrationFileContent);
    }

    public function testActionRun_ExecuteEveryMigrationAndItsSafeUpMethod()
    {
        $migrationController = $this->createMigrationController();
        $migrationController->migrationMock = $this->getMockBuilder(stdClass::class)->setMethods(['safeUp'])->getMock();

        $migrationController->migrationMock->expects($this->once())->method('safeUp');

        $migrationController->actionRun();
    }

    public function testActionDown_ExecuteEveryMigrationAndItsSafeDownMethod()
    {
        $migrationController = $this->createMigrationController();
        $migrationController->migrationMock = $this->getMockBuilder(stdClass::class)->setMethods(['safeDown'])->getMock();

        $migrationController->migrationMock->expects($this->once())->method('safeDown');

        $migrationController->actionDown();
    }

    /* Do i really need the test?
     * public function testRun_DatabaseConnectionPassedWhileCreationOfMigrationClass()
    {
        $migrationController = $this->createMigrationController();
        $migrationController->migrationMock = $this->getMockBuilder(stdClass::class)->setMethods(['safeUp'])->getMock();
        $migrationController->setDb($this->createMock(DatabaseConnection::class));

        $migrationController->actionRun();


    }*/

    protected function createMigrationController()
    {
        return new class() extends MigrationController {
            public $migrationName;
            public $migrationFileContent;
            public $migrationMock;

            public function createMigrationFile(string $fileName, $content)
            {
                $this->migrationName = $fileName;
                $this->migrationFileContent = $content;
            }

            public function getTemplateContent()
            {
                return 'class MigrationClassTemplate';
            }

            public function getMigrationClass($class)
            {
                return $this->migrationMock;
            }

            public function getMigrations()
            {
                return ['filename.php'];
            }
        };
    }
}