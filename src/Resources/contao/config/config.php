<?php

/*
 * This file is part of Oveleon company bundle.
 *
 * (c) https://www.oveleon.de/
 */

// Front end modules
$GLOBALS['FE_MOD']['company'] = array
(
    'logo'            => 'Oveleon\\ContaoCompanyBundle\\ModuleLogo',
    'socialmedialist' => 'Oveleon\\ContaoCompanyBundle\\ModuleSocialMediaList'
);

// Register hooks
$GLOBALS['TL_HOOKS']['loadPageDetails'][]   = array('Oveleon\\ContaoCompanyBundle\\Company', 'initialize');
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

// Skip page types
$GLOBALS['TL_COMPANY_ALLOWED_PAGE_TYPES'] = array();