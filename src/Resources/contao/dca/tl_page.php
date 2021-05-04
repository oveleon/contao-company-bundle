<?php

/*
 * This file is part of Oveleon company bundle.
 *
 * (c) https://www.oveleon.de/
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
        return Contao\System::getCountries();
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
    'eval'                    => array('maxlength'=>255, 'rgxp'=>'email', 'decodeEntities'=>true, 'tl_class'=>'w50 clr'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyEmail2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyEmail2'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'rgxp'=>'email', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyInfo'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyInfo'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['companyInfo2'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_page']['companyInfo2'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
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
                'label'                 => &$GLOBALS['TL_LANG']['tl_page']['companyType'],
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
                'reference'             => &$GLOBALS['TL_LANG']['tl_page'],
                'eval' 			        => array('includeBlankOption'=>true, 'style'=>'width:100%')
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
