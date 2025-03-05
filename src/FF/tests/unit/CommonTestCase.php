<?php

declare(strict_types=1);

namespace FF\tests\unit;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

class CommonTestCase extends TestCase
{
    protected ContainerInterface $nativeContainer;

    public function setUp(): void
    {
    }
}
