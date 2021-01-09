<?php
declare(strict_types=1);

namespace FF\tests\integrational\core;

use FF\Application;
use FF\container\PHPDIContainer;
use FF\tests\unit\CommonTestCase;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

final class ApplicationTest extends CommonTestCase
{
    public function testRun()
    {
        $this->createApplication()->run();
        $this->assertNotEmpty($this->getActualOutput());
    }

    private function createApplication(array $config = []): Application
    {
        return new Application(new PHPDIContainer($this->definitions()), $config);
    }

    private function definitions(): array
    {
        return [
            Logger::class => function (ContainerInterface $c) {
                return new Logger('Request_logger');
            }
        ];
    }


}
