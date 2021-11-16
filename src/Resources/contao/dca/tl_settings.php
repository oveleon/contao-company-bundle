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

// Extend the default palette
Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend('company_legend', 'chmod_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER, true)
    ->addField(array('companyLogo', 'companyName', 'companyStreet', 'companyPostal', 'companyCity', 'companyState', 'companyCountry', 'companyPhone', 'companyPhone2', 'companyFax', 'companyEmail', 'companyEmail2', 'companyInfo', 'companyInfo2', 'companySocialMedia'), 'company_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_settings')
;

// Load Company language files
System::loadLanguageFile('tl_company');
System::loadLanguageFile('tl_company_socials');

// Add fields to tl_settings
$GLOBALS['TL_DCA']['tl_settings']['fields']['companyLogo'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyLogo'],
    'inputType'               => 'fileTree',
    'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'extensions'=>Contao\Config::get('validImageTypes'))
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyName'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyName'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyStreet'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyStreet'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyPostal'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyPostal'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyCity'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyCity'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyState'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyState'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyCountry'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyCountry'],
    'inputType'               => 'select',
    'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    'options_callback' => function ()
    {
        return Contao\System::getCountries();
    }
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyPhone'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyPhone'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyPhone2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyPhone2'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyFax'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyFax'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyEmail'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyEmail'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'rgxp'=>'email', 'decodeEntities'=>true, 'tl_class'=>'w50 clr')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyEmail2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyEmail2'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'rgxp'=>'email', 'decodeEntities'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyInfo'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyInfo'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companyInfo2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyInfo2'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['companySocialMedia'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companySocialMedia'],
	'inputType' 	          => 'cySelectTextWizard',
	'options'                 => array
	(
		'facebook',
		'instagram',
		'twitter',
		'xing',
		'linkedin',
		'youtube',
		'vimeo',
		'twitch',
		'tiktok',
		'whatsapp',
		'telegram',
		'flickr',
		'behance',
		'pinterest',
		'bitbucket',
		'github',
		'gitlab',
		'reddit',
		'rss',
		'tumblr'
	),
	'reference'               => &$GLOBALS['TL_LANG']['tl_company_socials'],
	'eval'                    => array
	(
		'includeBlankOption' => true,
		'chosen' => true,
		'tl_class' => 'clr',
		'dragAndDrop' => true,
		'fieldNames' => array
		(
			'type',
			'url'
		),
		'fieldLabels' => array
		(
			&$GLOBALS['TL_LANG']['tl_company']['companyType'],
			&$GLOBALS['TL_LANG']['tl_company']['url']
		)
	),
    'sql'                     => "blob NULL"
);
