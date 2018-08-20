<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 20.08.18
 * Time: 14:34
 */

namespace core\logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Psr\Log\LoggerInterface;

class MonologLogger implements LoggerInterface
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct()
    {
        $logger = new Logger('Request_logger');

        $logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/my_app.log', Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());

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