<?php

declare(strict_types=1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

return (new Configuration())
    ->ignoreUnknownClasses([
        'Oveleon\ProductInstaller\Import\Prompt\FormPromptType',
        'Oveleon\ProductInstaller\Import\TableImport',
        'Oveleon\ProductInstaller\Import\Validator',
        'Oveleon\ProductInstaller\ProductInstaller'
    ])

    ->ignoreErrorsOnPackage('contao/manager-plugin', [ErrorType::DEV_DEPENDENCY_IN_PROD])
;
