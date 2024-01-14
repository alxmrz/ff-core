<?php

namespace FF\tests\integration;

use FF\container\PHPDIContainer;
use FF\tests\unit\CommonTestCase;

class PHPDIContainerTest extends CommonTestCase
{
    /**
     * @throws \Exception
     */
    public function testHas()
    {
        $container = new PHPDIContainer([PHPDIContainerTest::class => function () {
            return new PHPDIContainerTest();
        }]);

        $this->assertTrue($container->has(PHPDIContainerTest::class));
    }

    public function testGet()
    {
        $container = new PHPDIContainer([PHPDIContainerTest::class => function () {
            return new PHPDIContainerTest();
        }]);

        $this->assertInstanceOf(PHPDIContainerTest::class, $container->get(PHPDIContainerTest::class));
    }
}