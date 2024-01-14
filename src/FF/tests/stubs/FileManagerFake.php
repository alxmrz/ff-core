<?php

namespace FF\tests\stubs;

use FF\libraries\FileManager;

class FileManagerFake extends FileManager
{
    public function isFileExist(string $filePath): bool
    {
        return true;
    }
}