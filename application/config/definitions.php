<?php

use core\view\View;
use \core\view\TwigEngine;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

return [
    Twig_Environment::class  => function () {
        $loader = new Twig_Loader_Filesystem(TEMPLATE_PATH);
        return new Twig_Environment(
            $loader,
            [
                'cache' => __DIR__ . '/../runtime/cache/twig/',
                'debug' => true
            ]
        );
    },

    TwigEngine::class => function (ContainerInterface $c) {
        return new TwigEngine(
            TEMPLATE_PATH,
            $c->get(Twig_Environment::class)
        );
    },

    View::class => function (ContainerInterface $c) {
        return new View(
            $c->get(TwigEngine::class)
        );
    },

    Logger::class => function (ContainerInterface $c) {
        $logger = new Logger('Request_logger');
        $logFile = __DIR__ . '/../runtime/logs/my_app.log';
        if (!file_exists($logFile)) {
            file_put_contents($logFile, '');
        }

        $logger->pushHandler(new StreamHandler($logFile, Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());
        return $logger;
    }
];
