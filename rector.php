<?php

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withAttributesSets(phpunit: true)
    ->withPaths([__DIR__ . '/src',])
    ->withPhpSets(php83:true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true
    );