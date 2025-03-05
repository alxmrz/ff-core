<?php

declare(strict_types=1);

namespace FF\logger;

use Monolog\Logger;
use Psr\Log\LoggerInterface;

class MonologLogger implements LoggerInterface
{
    public function __construct(private readonly Logger $logger)
    {
    }

    public function info($message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    public function debug($message, array $context = []): void
    {
        $this->logger->debug($message, $context);
    }

    public function critical($message, array $context = []): void
    {
        $this->logger->crit($message, $context);
    }

    public function emergency($message, array $context = []): void
    {
        $this->logger->emerg($message, $context);
    }

    public function alert($message, array $context = []): void
    {
        $this->logger->alert($message, $context);
    }

    public function error($message, array $context = []): void
    {
        $this->logger->err($message, $context);
    }

    public function warning($message, array $context = []): void
    {
        $this->logger->warn($message, $context);
    }

    public function notice($message, array $context = []): void
    {
        $this->logger->notice($message, $context);
    }

    public function log($level, $message, array $context = [])
    {
    }
}
