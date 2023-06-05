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
use Oveleon\ContaoCompanyBundle\ModuleLogo;
use Oveleon\ContaoCompanyBundle\ModuleSocialMediaList;

$GLOBALS['FE_MOD']['company'] = [
    'logo'            => ModuleLogo::class,
    'socialmedialist' => ModuleSocialMediaList::class
];

// Register hooks
$GLOBALS['TL_HOOKS']['getPageLayout'][] = ['Oveleon\ContaoCompanyBundle\Company', 'initialize'];

// Company field mapping
$GLOBALS['TL_COMPANY_MAPPING'] = [
    'logo'        => 'companyLogo',
    'name'        => 'companyName',
    'street'      => 'companyStreet',
    'postal'      => 'companyPostal',
    'city'        => 'companyCity',
    'state'       => 'companyState',
    'country'     => 'companyCountry',
    'phone'       => 'companyPhone',
    'phone2'      => 'companyPhone2',
    'fax'         => 'companyFax',
    'email'       => 'companyEmail',
    'email2'      => 'companyEmail2',
    'info'        => 'companyInfo',
    'info2'       => 'companyInfo2',
    'socialmedia' => 'companySocialMedia'
];

// Back end form fields
$GLOBALS['BE_FFL']['cyColumnWizard'] = CompanyColumnWizard::class;
