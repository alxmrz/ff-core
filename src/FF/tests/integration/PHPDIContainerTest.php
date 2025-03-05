<?php

declare(strict_types=1);

namespace FF\tests\integration;

use FF\container\PHPDIContainer;
use FF\tests\unit\CommonTestCase;

final class PHPDIContainerTest extends CommonTestCase
{
    /**
     * @throws \Exception
     */
    public function testHas(): void
    {
        $container = new PHPDIContainer(
            [PHPDIContainerTest::class => fn(): PHPDIContainerTest => new PHPDIContainerTest()]
        );

        $this->assertTrue($container->has(PHPDIContainerTest::class));
    }

    public function testGet(): void
    {
        $container = new PHPDIContainer(
            [PHPDIContainerTest::class => fn(): PHPDIContainerTest => new PHPDIContainerTest()]
        );

        $this->assertInstanceOf(PHPDIContainerTest::class, $container->get(PHPDIContainerTest::class));
    }
}
