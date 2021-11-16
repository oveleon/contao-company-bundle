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

// Front end modules
$GLOBALS['FE_MOD']['company'] = array
(
    'logo'            => 'Oveleon\ContaoCompanyBundle\ModuleLogo',
    'socialmedialist' => 'Oveleon\ContaoCompanyBundle\ModuleSocialMediaList'
);

// Register hooks
$GLOBALS['TL_HOOKS']['getPageLayout'][]     = array('Oveleon\ContaoCompanyBundle\Company', 'initialize');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('contao_company.listener.insert_tags', 'onReplaceInsertTags');

// Company field mapping
$GLOBALS['TL_COMPANY_MAPPING'] = array
(
    'logo' => 'companyLogo',
    'name' => 'companyName',
    'street' => 'companyStreet',
    'postal' => 'companyPostal',
    'city' => 'companyCity',
    'state' => 'companyState',
    'country' => 'companyCountry',
    'phone' => 'companyPhone',
    'phone2' => 'companyPhone2',
    'fax' => 'companyFax',
    'email' => 'companyEmail',
    'email2' => 'companyEmail2',
    'info' => 'companyInfo',
    'info2' => 'companyInfo2',
    'socialmedia' => 'companySocialMedia'
);

// Back end form fields
$GLOBALS['BE_FFL']['cySelectTextWizard']          = 'Oveleon\ContaoCompanyBundle\SelectTextWizard';

// Widget JavaScript
if (defined('TL_MODE') && TL_MODE === 'BE')
{
	$GLOBALS['TL_JAVASCRIPT'][] = 'bundles/contaocompany/scripts/widget.js';
	$GLOBALS['TL_CSS'][]        = 'bundles/contaocompany/styles/selectTextWizard.css';
}