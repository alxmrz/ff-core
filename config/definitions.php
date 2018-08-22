<?php

use core\view\View;
use \core\view\TwigEngine;
use Psr\Container\ContainerInterface;

return [
    Twig_Environment::class  => function () {
        $loader = new Twig_Loader_Filesystem(TEMPLATE_PATH);
        return new Twig_Environment(
            $loader,
            [
                'cache' => '../cache/twig/',
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
    }
];
