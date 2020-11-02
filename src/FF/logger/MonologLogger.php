<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 20.08.18
 * Time: 14:34
 */

namespace FF\logger;

use Monolog\Logger;
use Psr\Log\LoggerInterface;

class MonologLogger implements LoggerInterface
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function info($message, array $context = [])
    {
        $this->logger->info($message, $context = []);
    }

    public function debug($message, array $context = [])
    {
        $this->logger->debug($message, $context = []);
    }

    public function critical($message, array $context = [])
    {
        $this->logger->crit($message, $context = []);
    }

    public function emergency($message, array $context = [])
    {
        $this->logger->emerg($message, $context = []);
    }

    public function alert($message, array $context = [])
    {
        $this->logger->alert($message, $context = []);
    }

    public function error($message, array $context = [])
    {
        $this->logger->err($message, $context = []);
    }

    public function warning($message, array $context = [])
    {
        $this->logger->warn($message, $context = []);
    }

    public function notice($message, array $context = [])
    {
        $this->logger->notice($message, $context = []);
    }

    public function log($level, $message, array $context = [])
    {
    }
}