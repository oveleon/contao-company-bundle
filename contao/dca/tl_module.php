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

// Add palettes to tl_module
$GLOBALS['TL_DCA']['tl_module']['palettes']['logo']            = '{title_legend},name,headline,type;{logo_legend},imgSize,companyLogoAddLink;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';
$GLOBALS['TL_DCA']['tl_module']['palettes']['socialmedialist'] = '{title_legend},name,headline,type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID';

// Add fields to tl_module
$GLOBALS['TL_DCA']['tl_module']['fields']['companyLogoAddLink'] = [
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => ['tl_class'=>'w50 m12'],
    'sql'                     => "char(1) NOT NULL default '1'"
];
