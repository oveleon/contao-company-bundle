<?php

declare(strict_types=1);

namespace Oveleon\ContaoCompanyBundle\Import\Validator;

use Contao\PageModel;

/**
 * Validator class for validating the company item records within a page during and after import.
 */
class CompanyPageValidator
{
    public static function getTrigger(): string
    {
        return PageModel::getTable();
    }

    public static function getModel(): string
    {
        return PageModel::class;
    }
}
