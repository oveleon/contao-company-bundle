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

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\System;
use Oveleon\ContaoCompanyBundle\EventListener\DataContainer\DataContainerListener;

// Extend the default palette
PaletteManipulator::create()
    ->addLegend('company_legend', 'chmod_legend', PaletteManipulator::POSITION_AFTER, true)
    ->addField(['companyLogo', 'companyName', 'companyStreet', 'companyPostal', 'companyCity', 'companyState', 'companyCountry', 'companyPhone', 'companyPhone2', 'companyFax', 'companyEmail', 'companyEmail2', 'companyInfo', 'companyInfo2', 'companySocialMedia'], 'company_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings')
;

// Load Company language files
System::loadLanguageFile('tl_company');
System::loadLanguageFile('tl_company_socials');

// Add fields to tl_settings
$GLOBALS['TL_DCA']['tl_settings']['fields']['companyLogo'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyLogo'],
    'inputType' => 'fileTree',
    'eval' => [
        'fieldType' => 'radio',
        'files' => true,
        'extensions' => '%contao.image.valid_extensions%',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyName'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyName'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyStreet'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyStreet'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyPostal'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyPostal'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 32,
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyCity'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyCity'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyState'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyState'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 64,
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyCountry'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyCountry'],
    'inputType' => 'select',
    'eval' => [
        'includeBlankOption' => true,
        'chosen' => true,
        'tl_class' => 'w50',
    ],
    'options_callback' => static function (): array
    {
        $countries = System::getContainer()->get('contao.intl.countries')->getCountries();

        return array_combine(array_map('strtolower', array_keys($countries)), $countries);
    },
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyPhone'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyPhone'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 64,
        'rgxp' => 'phone',
        'decodeEntities' => true,
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyPhone2'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyPhone2'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 64,
        'rgxp' => 'phone',
        'decodeEntities' => true,
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyFax'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyFax'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 64,
        'rgxp' => 'phone',
        'decodeEntities' => true,
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyEmail'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyEmail'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'rgxp' => 'email',
        'decodeEntities' => true,
        'tl_class' => 'w50 clr',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyEmail2'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyEmail2'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'rgxp' => 'email',
        'decodeEntities' => true,
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyInfo'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyInfo'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyInfo2'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companyInfo2'],
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 255,
        'tl_class' => 'w50',
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['companySocialMedia'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_company']['companySocialMedia'],
    'inputType' => 'cyColumnWizard',
    'eval' => [
        'includeBlankOption' => true,
        'tl_class' => 'clr',
        'dragAndDrop' => true,
        'columnFields' => [
            'type' => [
                'label' => &$GLOBALS['TL_LANG']['tl_company']['companyType'],
                'inputType' => 'select',
                'options_callback' => static fn () => array_keys($GLOBALS['TL_LANG']['tl_company_socials']),
                'reference' => &$GLOBALS['TL_LANG']['tl_company_socials'],
                'eval' => [
                    'includeBlankOption' => true,
                    'chosen' => true,
                    'tl_class' => 'clr',
                ],
            ],
            'url' => [
                'label' => &$GLOBALS['TL_LANG']['tl_company']['url'],
                'inputType' => 'text',
            ],
        ],
    ],
    'save_callback' => [
        DataContainerListener::clearEmptySocialMediaValue(...),
    ],
    'sql' => 'blob NULL',
];
