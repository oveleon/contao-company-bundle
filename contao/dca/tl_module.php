<?php

declare(strict_types=1);

/*
 * This file is part of Oveleon Company Bundle.
 *
 * @package     contao-company-bundle
 * @license     MIT
 * @author      Fabian Ekert        <https://github.com/eki89>
 * @author      Sebastian Zoglowek  <https://github.com/zoglo>
 * @copyright   Oveleon             <https://www.oveleon.de/>
 */

// Add palettes to tl_module
$GLOBALS['TL_DCA']['tl_module']['palettes']['logo'] = '{title_legend},name,headline,type;{logo_legend},imgSize,companyLogoRedirect;{template_legend:collapsed},customTpl;{protected_legend:collapsed},protected;{expert_legend:collapsed},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['socialmedialist'] = '{title_legend},name,headline,type;{template_legend:collapsed},customTpl;{protected_legend:collapsed},protected;{expert_legend:collapsed},guests,cssID';

// Add fields to tl_module
$GLOBALS['TL_DCA']['tl_module']['fields']['companyLogoRedirect'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default '1'",
];
