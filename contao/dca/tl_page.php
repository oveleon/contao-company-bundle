<?php

/*
 * This file is part of Oveleon Company Bundle.
 *
 * @package     contao-company-bundle
 * @license     MIT
 * @author      Fabian Ekert        <https://github.com/eki89>
 * @author      Sebastian Zoglowek  <https://github.com/zoglo>
 * @copyright   Oveleon             <https://www.oveleon.de/>
 */

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\System;
use Oveleon\ContaoCompanyBundle\EventListener\DataContainer\DataContainerListener;

// Initialize the palette-manipulator
$manipulator = PaletteManipulator::create();

// Add the legend and fields to the root palette of tl_page
$manipulator
    ->addLegend('company_legend', 'chmod_legend', PaletteManipulator::POSITION_AFTER, true)
    ->addField(['companyLogo', 'companyName', 'companyStreet', 'companyPostal', 'companyCity', 'companyState', 'companyCountry', 'companyPhone', 'companyPhone2', 'companyFax', 'companyEmail', 'companyEmail2', 'companyInfo', 'companyInfo2', 'companySocialMedia'], 'company_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('root', 'tl_page')
;

// Check if the root fallback palette exists
if (array_key_exists('rootfallback', $GLOBALS['TL_DCA']['tl_page']['palettes']))
{
    $manipulator->applyToPalette('rootfallback', 'tl_page');
}

// Load Company language files
System::loadLanguageFile('tl_company');
System::loadLanguageFile('tl_company_socials');

// Add fields to tl_page
$GLOBALS['TL_DCA']['tl_page']['fields']['companyLogo'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyLogo'],
    'inputType'               => 'fileTree',
    'eval'                    => ['fieldType'=>'radio', 'files'=>true, 'extensions'=>'%contao.image.valid_extensions%'],
    'sql'                     => "binary(16) NULL"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyName'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyName'],
    'inputType'               => 'text',
    'eval'                    => ['maxlength'=>255, 'tl_class'=>'w50'],
    'sql'                     => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyStreet'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyStreet'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['maxlength'=>255, 'tl_class'=>'w50'],
    'sql'                     => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyPostal'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyPostal'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['maxlength'=>32, 'tl_class'=>'w50'],
    'sql'                     => "varchar(32) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyCity'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyCity'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['maxlength'=>255, 'tl_class'=>'w50'],
    'sql'                     => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyState'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyState'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['maxlength'=>64, 'tl_class'=>'w50'],
    'sql'                     => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyCountry'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyCountry'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'eval'                    => ['includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'],
    'options_callback'        => static fn () => System::getContainer()->get('contao.intl.countries')->getCountries(),
    'sql'                     => "varchar(2) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyPhone'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyPhone'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'],
    'sql'                     => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyPhone2'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyPhone2'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'],
    'sql'                     => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyFax'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyFax'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'],
    'sql'                     => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyEmail'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyEmail'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['maxlength'=>255, 'rgxp'=>'email', 'decodeEntities'=>true, 'tl_class'=>'w50 clr'],
    'sql'                     => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyEmail2'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyEmail2'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['maxlength'=>255, 'rgxp'=>'email', 'decodeEntities'=>true, 'tl_class'=>'w50'],
    'sql'                     => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyInfo'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyInfo'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['maxlength'=>255, 'tl_class'=>'w50'],
    'sql'                     => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companyInfo2'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyInfo2'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => ['maxlength'=>255, 'tl_class'=>'w50'],
    'sql'                     => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_page']['fields']['companySocialMedia'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companySocialMedia'],
    'inputType' 	          => 'cyColumnWizard',
    'eval'                    => [
        'tl_class' => 'clr',
        'dragAndDrop' => true,
        'columnFields' => [
            'type' => [
                'label'            => &$GLOBALS['TL_LANG']['tl_company']['companyType'],
                'inputType'        => 'select',
                'options_callback' => static fn () => array_keys($GLOBALS['TL_LANG']['tl_company_socials']),
                'reference'        => &$GLOBALS['TL_LANG']['tl_company_socials'],
                'eval'             => ['includeBlankOption' => true, 'chosen' => true, 'tl_class' => 'clr']
            ],
            'url' => [
                'label'            => &$GLOBALS['TL_LANG']['tl_company']['url'],
                'inputType'        => 'text'
            ]
        ],
    ],
    'save_callback' => [
        [DataContainerListener::class, 'clearEmptySocialMediaValue']
    ],
    'sql' => "blob NULL"
];
