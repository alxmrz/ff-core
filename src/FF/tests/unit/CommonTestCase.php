<?php
declare(strict_types=1);
namespace FF\tests\unit;

use FF\container\PHPDIContainer;
use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

class CommonTestCase extends TestCase
{
    /**
     * @var ContainerInterface
     */
    protected $nativeContainer;

    public function setUp()
    {
        $definitions = require __DIR__ . '/../../config/definitions.php';
        $this->nativeContainer = new PHPDIContainer($definitions);
    }
}
