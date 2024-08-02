<?php

declare(strict_types=1);

namespace Oveleon\ContaoCompanyBundle\Export\Validator;

use Contao\PageModel;

/**
 * Validator class for validating the company item records within a page during export.
 */
class ExportFileValidator
{
    public function addSingleSrcValidator($exporter): void
    {
        $exporter->addValidator(PageModel::getTable(), static function (array|PageModel &$model) use ($exporter): void
        {
            $exporter->convertSingleUuid($model, 'companyLogo');
        });
    }
}
