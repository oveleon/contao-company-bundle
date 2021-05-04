<?php

/*
 * This file is part of Oveleon company bundle.
 *
 * (c) https://www.oveleon.de/
 */

// Extend the default palette
Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('company_legend', 'chmod_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER, true)
    ->addField(array('companyLogo', 'companyName', 'companyStreet', 'companyPostal', 'companyCity', 'companyState', 'companyCountry', 'companyPhone', 'companyPhone2', 'companyFax', 'companyEmail', 'companyEmail2', 'companyInfo', 'companyInfo2', 'companySocialMedia'), 'company_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings')
;

// Add fields to tl_settings
$GLOBALS['TL_DCA']['tl_settings']['fields']['companyLogo'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyLogo'],
    'inputType'               => 'fileTree',
    'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'extensions'=>Contao\Config::get('validImageTypes'))
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyName'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyName'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyStreet'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyStreet'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyPostal'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyPostal'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyCity'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyCity'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyState'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyState'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyCountry'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyCountry'],
    'inputType'               => 'select',
    'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    'options_callback' => function ()
    {
        return Contao\System::getCountries();
    }
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyPhone'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyPhone'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyPhone2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyPhone2'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyFax'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyFax'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyEmail'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyEmail'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'rgxp'=>'email', 'decodeEntities'=>true, 'tl_class'=>'w50 clr')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyEmail2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyEmail2'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'rgxp'=>'email', 'decodeEntities'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyInfo'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyInfo'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyInfo2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyInfo2'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companySocialMedia'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_settings']['companySocialMedia'],
    'inputType' 	            => 'multiColumnWizard',
    'eval' 			            => array
    (
        'columnFields' => array
        (
            'type' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_settings']['companyType'],
                'inputType'             => 'select',
                'options'               => array
                (
                    'bitbucket',
                    'facebook',
                    'flickr',
                    'github',
                    'gitlab',
                    'instagram',
                    'linkedin',
                    'pinterest',
                    'reddit',
                    'rss',
                    'tumblr',
                    'twitter',
                    'vimeo',
                    'xing',
                    'youtube',
                    'behance',
                    'whatsapp'
                ),
                'reference'             => &$GLOBALS['TL_LANG']['tl_settings'],
                'eval' 			        => array('includeBlankOption'=>true, 'style'=>'width:100%')
            ),
            'url' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_settings']['url'],
                'inputType'             => 'text',
                'eval' 			        => array('style'=>'width:100%')
            )
        ),
        'tl_class' => 'clr'
    ),
    'sql'                     => "blob NULL"
);
