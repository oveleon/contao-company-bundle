<?php

namespace Oveleon\ContaoCompanyBundle\Export\Validator;

use Contao\PageModel;

/**
 * Validator class for validating the company item records within a page during export.
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 */
class ExportFileValidator
{
    public function addSingleSrcValidator($exporter): void
    {
        $exporter->addValidator(PageModel::getTable(), function (PageModel $model) use ($exporter)
        {
            $exporter->convertSingleUuid($model, 'companyLogo');
        });
    }
}
