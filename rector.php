<?php

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withAttributesSets(phpunit: true)
    ->withPaths([__DIR__ . '/src',])
    ->withPhpSets(php83:true)
    ->withSets([
        SetList::DEAD_CODE,
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,
        SetList::RECTOR_PRESET,
    ]);