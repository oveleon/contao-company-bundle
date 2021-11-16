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

// Initialize the palette-manipulator
$manipulator = Contao\CoreBundle\DataContainer\PaletteManipulator::create();

// Add the legend and fields to the root palette of tl_page
$manipulator
    ->addLegend('company_legend', 'chmod_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER, true)
    ->addField(array('companyLogo', 'companyName', 'companyStreet', 'companyPostal', 'companyCity', 'companyState', 'companyCountry', 'companyPhone', 'companyPhone2', 'companyFax', 'companyEmail', 'companyEmail2', 'companyInfo', 'companyInfo2', 'companySocialMedia'), 'company_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('root', 'tl_page')
;

// Check if the rootfallback palette exists
if (array_key_exists('rootfallback', $GLOBALS['TL_DCA']['tl_page']['palettes'])) {
    $manipulator->applyToPalette('rootfallback', 'tl_page');
}

// Load Company language files
System::loadLanguageFile('tl_company');
System::loadLanguageFile('tl_company_socials');

// Add fields to tl_page
$GLOBALS['TL_DCA']['tl_page']['fields']['companyLogo'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyLogo'],
    'inputType'               => 'fileTree',
    'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'extensions'=>Contao\Config::get('validImageTypes')),
    'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyName'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyName'],
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyStreet'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyStreet'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyPostal'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyPostal'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>32, 'tl_class'=>'w50'),
    'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyCity'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyCity'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyState'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyState'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyCountry'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyCountry'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    'options_callback' => function ()
    {
        return Contao\System::getCountries();
    },
    'sql'                     => "varchar(2) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyPhone'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyPhone'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyPhone2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyPhone2'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyFax'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyFax'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyEmail'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyEmail'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'rgxp'=>'email', 'decodeEntities'=>true, 'tl_class'=>'w50 clr'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyEmail2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyEmail2'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'rgxp'=>'email', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyInfo'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyInfo'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyInfo2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_company']['companyInfo2'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companySocialMedia'] = array
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
    'save_callback' => array
    (
        array('tl_page_company', 'clearEmptyValue')
    ),
    'sql'                     => "blob NULL"
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class tl_page_company extends Contao\Backend
{
    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('Contao\BackendUser', 'User');
    }

    /**
     * Clears field socialmedia if no records found
     *
     * @param mixed                $varValue
     * @param Contao\DataContainer $dc
     *
     * @return string
     */
    public function clearEmptyValue($varValue, Contao\DataContainer $dc): string
    {
        if ($varValue == '')
        {
            return $varValue;
        }

        $arrValue = Contao\StringUtil::deserialize($varValue, true);

        if (!count($arrValue))
        {
            return '';
        }

        if (array_key_exists('type', $arrValue[0]))
        {
            if ($arrValue[0]['type'] === '')
            {
                return '';
            }
        }

        return $varValue;
    }
}
