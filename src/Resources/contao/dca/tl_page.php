<?php

/*
 * This file is part of Oveleon company bundle.
 *
 * (c) https://www.oveleon.de/
 */

// Extend the default palette
Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('company_legend', 'chmod_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER, true)
    ->addField(array('companyLogo', 'companyName', 'companyStreet', 'companyPostal', 'companyCity', 'companyState', 'companyCountry', 'companyPhone', 'companyPhone2', 'companyFax', 'companyEmail', 'companySocialMedia'), 'company_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette(array_key_exists('rootfallback', $GLOBALS['TL_DCA']['tl_page']['palettes']) ? 'rootfallback' : 'root', 'tl_page')
;

// Add fields to tl_page
$GLOBALS['TL_DCA']['tl_page']['fields']['companyLogo'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyLogo'],
    'inputType'               => 'fileTree',
    'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'extensions'=>Contao\Config::get('validImageTypes')),
    'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyName'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyName'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyStreet'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyStreet'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyPostal'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyPostal'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
    'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyCity'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyCity'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyState'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyState'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyCountry'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyCountry'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    'options_callback' => function ()
    {
        return System::getCountries();
    },
    'sql'                     => "varchar(2) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyPhone'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyPhone'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyPhone2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyPhone2'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyFax'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyFax'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyEmail'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyEmail'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'rgxp'=>'email', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companySocialMedia'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_page']['companySocialMedia'],
    'inputType' 	            => 'multiColumnWizard',
    'eval' 			            => array
    (
        'columnFields' => array
        (
            'type' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_page']['type'],
                'inputType'             => 'select',
                'options'               => array
                (
                    'bitbucket',
                    'facebook',
                    'flickr',
                    'github',
                    'gitlab',
                    'googleplus',
                    'instagram',
                    'linkedin',
                    'pinterest',
                    'reddit',
                    'rss',
                    'tumblr',
                    'twitter',
                    'vimeo',
                    'xing',
                    'youtube'
                ),
                'reference'             => &$GLOBALS['TL_LANG']['tl_page'],
                'eval' 			        => array('style'=>'width:100%')
            ),
            'url' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_page']['url'],
                'inputType'             => 'text',
                'eval' 			        => array('style'=>'width:100%')
            )
        ),
        'tl_class' => 'clr'
    ),
    'sql'                     => "blob NULL"
);
