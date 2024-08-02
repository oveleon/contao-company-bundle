<?php

declare(strict_types=1);

use Contao\Rector\Set\ContaoLevelSetList;
use Contao\Rector\Set\ContaoSetList;
use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
    )
    ->withPhpSets(
        php81: true,
    )
    ->withAttributesSets(
        symfony: true,
    )
    ->withSets([
        ContaoLevelSetList::UP_TO_CONTAO_413,
        ContaoSetList::ANNOTATIONS_TO_ATTRIBUTES
    ])
    ->withPaths([
        __DIR__.'/contao',
        __DIR__.'/src',
    ])
    ->withImportNames(removeUnusedImports: true)
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
    ])
    ->withParallel()
;
