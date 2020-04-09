<?php

/*
 * This file is part of Oveleon company bundle.
 *
 * (c) https://www.oveleon.de/
 */

$GLOBALS['TL_DCA']['tl_module']['palettes']['logo']            = '{title_legend},name,headline,type;{logo_legend},imgSize;{responsive_logo_legend},companyLogo;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['socialmedialist'] = '{title_legend},name,headline,type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

$GLOBALS['TL_DCA']['tl_module']['fields']['companyLogo'] = array
(
    'label'                     => &$GLOBALS['TL_LANG']['tl_module']['companyLogo'],
    'inputType' 	            => 'multiColumnWizard',
    'eval' 			            => array
    (
        'columnFields' => array
        (
            'imageSRC' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_module']['imageSRC'],
                'inputType'             => 'fileTree',
                'eval' 			        => array('fieldType'=>'radio', 'files'=>true, 'extensions'=>Contao\Config::get('validImageTypes'))
            ),
            'width' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_module']['width'],
                'inputType'             => 'text',
                'eval' 			        => array('style'=>'width:100%')
            ),
            'breakpoint' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_module']['breakpoint'],
                'inputType'             => 'text',
                'eval' 			        => array('style'=>'width:100%')
            )
        )
    ),
    'sql'                     => "blob NULL"
);
