<?php

/*
 * This file is part of Oveleon company bundle.
 *
 * (c) https://www.oveleon.de/
 */

// Front end modules
$GLOBALS['FE_MOD']['company'] = array
(
    'socialmedialist' => 'Oveleon\\ContaoCompanyBundle\\ModuleSocialMediaList'
);

// Register hooks
$GLOBALS['TL_HOOKS']['loadPageDetails'][]   = array('Oveleon\\ContaoCompanyBundle\\Company', 'initialize');
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = array('contao_company.listener.insert_tags', 'onReplaceInsertTags');

// Company field mapping
$GLOBALS['TL_COMPANY_MAPPING'] = array
(
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
    'website' => 'companyWebsite',
    'socialmedia' => 'companySocialMedia'
);