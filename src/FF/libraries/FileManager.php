<?php

declare(strict_types=1);

namespace FF\libraries;

use FF\exceptions\FileNotCreated;
use FF\exceptions\UnavailablePath;

class FileManager
{
    public function isFileExist(string $filePath): bool
    {
        return file_exists($filePath);
    }
}
