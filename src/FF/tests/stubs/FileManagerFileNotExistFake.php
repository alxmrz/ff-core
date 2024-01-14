<?php

namespace FF\tests\stubs;

use FF\libraries\FileManager;

class FileManagerFileNotExistFake extends FileManager
{
    private array $returnValues;

    public function __construct(array $returnValues = [])
    {

        $this->returnValues = $returnValues;
    }

    public function isFileExist(string $filePath): bool
    {
        return false;
    }
}