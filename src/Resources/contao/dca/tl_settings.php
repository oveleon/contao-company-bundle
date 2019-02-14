<?php
// Add fields to palette
$GLOBALS['TL_DCA']['tl_settings']['palettes'] = str_replace('{date_legend}', '{company_legend},companyName,companyStreet,companyPostal,companyCity,companyState,companyCountry,companyPhone,companyPhone2,companyFax,companyEmail,companyWebsite;{date_legend}', $GLOBALS['TL_DCA']['tl_settings']['palettes']);

// Add fields
array_insert($GLOBALS['TL_DCA']['tl_settings']['fields'], 0, array
(
    'companyName' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyName'],
        'inputType'               => 'text',
        'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    ),
    'companyStreet' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyStreet'],
        'inputType'               => 'text',
        'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    ),
    'companyPostal' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyPostal'],
        'inputType'               => 'text',
        'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    ),
    'companyCity' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyCity'],
        'inputType'               => 'text',
        'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    ),
    'companyState' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyState'],
        'inputType'               => 'text',
        'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
    ),
    'companyCountry' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyCountry'],
        'inputType'               => 'select',
        'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
        'options_callback' => function ()
        {
            return System::getCountries();
        }
    ),
    'companyPhone' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyPhone'],
        'inputType'               => 'text',
        'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    ),
    'companyPhone2' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyPhone2'],
        'inputType'               => 'text',
        'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    ),
    'companyFax' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyFax'],
        'inputType'               => 'text',
        'eval'                    => array('maxlength'=>64, 'rgxp'=>'phone', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    ),
    'companyEmail' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyEmail'],
        'inputType'               => 'text',
        'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'rgxp'=>'email', 'decodeEntities'=>true, 'tl_class'=>'w50'),
    ),
    'companyWebsite' => array
    (
        'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['companyWebsite'],
        'inputType'               => 'text',
        'eval'                    => array('maxlength'=>255, 'rgxp'=>'url', 'tl_class'=>'w50'),
    )
));