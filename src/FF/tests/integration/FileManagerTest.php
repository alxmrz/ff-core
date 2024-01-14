<?php

namespace FF\tests\integration;

use FF\libraries\FileManager;
use FF\tests\unit\CommonTestCase;

class FileManagerTest extends CommonTestCase
{
    public function testIsFileExist(): void
    {
        $fm = new FileManager();

        $this->assertTrue($fm->isFileExist(__DIR__ . '/FileManagerTest.php'));
        $this->assertFalse($fm->isFileExist(__DIR__ . '/FileManagerTest123.php'));
    }
}
