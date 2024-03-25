<?php

namespace Oveleon\ContaoCompanyBundle\Import\Validator;

use Contao\PageModel;

/**
 * Validator class for validating the company item records within a page during and after import.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class CompanyPageValidator
{
    static public function getTrigger(): string
    {
        return PageModel::getTable();
    }

    static public function getModel(): string
    {
        return PageModel::class;
    }
}
