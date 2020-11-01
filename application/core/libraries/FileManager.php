<?php


namespace core\libraries;


use core\exceptions\FileNotCreated;
use core\exceptions\UnavailablePath;

class FileManager
{
    /**
     * @param string $fileName
     * @return string
     */
    public function getContent(string $fileName): string
    {
        return file_get_contents($fileName);
    }

    /**
     * @param string $filePath
     * @param string $content
     * @return bool
     * @throws FileNotCreated
     * @throws UnavailablePath
     */
    public function createFile(string $filePath, string $content): bool
    {
        $pathInfo = pathinfo($filePath);

        if (!is_dir($pathInfo['dirname'])) {
            throw new UnavailablePath("Path not found: $filePath");
        }

        if (!file_put_contents($filePath, $content)) {
            throw new FileNotCreated($filePath);
        }

        return true;
    }

    public function scanDir(string $dirPath): array
    {
        if (!is_dir($dirPath)) {
            throw new UnavailablePath("Path not found: $dirPath");
        }

        return scandir($dirPath);
    }
}