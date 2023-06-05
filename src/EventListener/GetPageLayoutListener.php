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

namespace Oveleon\ContaoCompanyBundle\EventListener;

use Contao\Config;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\PageRegular;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\System;

/**
 * @Hook("getPageLayout")
 */
class GetPageLayoutListener
{
    public function __invoke(PageModel $pageModel, LayoutModel $layout, PageRegular $pageRegular): void
    {
        $rootPage = PageModel::findByPk($pageModel->rootId);
        $company  = System::getContainer()->get('contao_company.company');

        foreach ($GLOBALS['TL_COMPANY_MAPPING'] as $key => $field)
        {
            $company->set($key, Config::get($field));

            if (!empty($rootPage->{$field}))
            {
                $company->set($key, $rootPage->{$field});
            }
        }
    }
}
