<?php

declare(strict_types=1);

/*
 * This file is part of Oveleon Company Bundle.
 *
 * @package     contao-company-bundle
 * @license     MIT
 * @author      Fabian Ekert        <https://github.com/eki89>
 * @author      Sebastian Zoglowek  <https://github.com/zoglo>
 * @copyright   Oveleon             <https://www.oveleon.de/>
 */

use Oveleon\ContaoCompanyBundle\EventListener\Import\AddCompanyPageValidatorListener;
use Oveleon\ContaoCompanyBundle\Export\Validator\ExportFileValidator;
use Oveleon\ContaoCompanyBundle\ModuleLogo;
use Oveleon\ContaoCompanyBundle\ModuleSocialMediaList;
use Oveleon\ContaoCompanyBundle\Widget\ColumnWizard;

$GLOBALS['FE_MOD']['company'] = [
    'logo' => ModuleLogo::class,
    'socialmedialist' => ModuleSocialMediaList::class,
];

// Company field mapping
$GLOBALS['TL_COMPANY_MAPPING'] = [
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
    'socialmedia' => 'companySocialMedia',
];

// Back end form fields
$GLOBALS['BE_FFL']['cyColumnWizard'] = ColumnWizard::class;

// Hooks
$GLOBALS['PI_HOOKS']['addValidator'][] = [AddCompanyPageValidatorListener::class, 'addValidators'];
$GLOBALS['PE_HOOKS']['addValidator'][] = [ExportFileValidator::class, 'addSingleSrcValidator'];
