<?php


namespace unit\console\services\migration;


use FF\console\services\migration\CreateService;
use FF\exceptions\MigrationNameNotProvidedException;
use FF\libraries\DateTime;
use FF\libraries\FileManager;
use PHPUnit\Framework\MockObject\MockObject;
use FF\tests\unit\CommonTestCase;

class CreateServiceTest extends CommonTestCase
{
    private DateTime $now;
    /** @var FileManager|MockObject */
    private $fileManager;

    public function testCreate()
    {
        $createService = $this->makeCreateService();

        $this->fileManager->method('getContent')->willReturn('class MigrationClassTemplate');
        $this->fileManager
            ->expects($this->once())
            ->method('createFile')
            ->withAnyParameters()
            ->willReturn(true);

        $this->assertTrue($createService->create('new_migration'));
    }

    public function testCreate_WhenMigrationNameNotProvidedThenException()
    {
        $createService = $this->makeCreateService();
        $this->expectException(MigrationNameNotProvidedException::class);

        $createService->create('');
    }

    protected function makeCreateService(): CreateService
    {
        $this->now = new DateTime('2020-01-01 00:00:00');
        $this->fileManager = $this->createMock(FileManager::class);

        return new CreateService($this->now, $this->fileManager);
    }
}