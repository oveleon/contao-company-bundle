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
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Routing\ResponseContext\JsonLd\JsonLdManager;
use Contao\CoreBundle\Routing\ResponseContext\ResponseContextAccessor;
use Contao\Environment;
use Contao\FilesModel;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;
use Contao\StringUtil;
use Contao\System;
use Oveleon\ContaoCompanyBundle\Company;
use Oveleon\ContaoCompanyBundle\SchemaOrg\CompanySchemaOrgBuilder;

#[AsHook('getPageLayout')]
class GetPageLayoutListener
{
    public function __construct(
        private readonly CompanySchemaOrgBuilder $schemaOrgBuilder,
        private readonly ResponseContextAccessor $responseContextAccessor,
    ) {
    }

    public function __invoke(PageModel $pageModel, LayoutModel $layout, PageRegular $pageRegular): void
    {
        $rootPage = PageModel::findById($pageModel->rootId);
        $company = System::getContainer()->get('contao_company.company');

        foreach ($GLOBALS['TL_COMPANY_MAPPING'] as $key => $field)
        {
            $company->set($key, Config::get($field));

            if (!empty($rootPage->{$field}))
            {
                $company->set($key, $rootPage->{$field});
            }
        }

        $this->addSchemaOrgData($company, $rootPage);
    }

    private function addSchemaOrgData(Company $company, PageModel $rootPage): void
    {
        if (
            !($responseContext = $this->responseContextAccessor->getResponseContext())
            || !$responseContext->has(JsonLdManager::class)
        ) {
            return;
        }

        $companyData = [];

        foreach (array_keys($GLOBALS['TL_COMPANY_MAPPING']) as $key)
        {
            $companyData[$key] = $company->get($key);
        }

        $companyData['socialmedia'] = StringUtil::deserialize($companyData['socialmedia'], true);

        $logoUrl = null;

        if (
            !empty($companyData['logo'])
            && null !== ($logo = FilesModel::findByUuid($companyData['logo']))
        ) {
            $logoUrl = rtrim(Environment::get('base'), '/') . '/' . ltrim($logo->path, '/');
        }

        if (null === ($schemaData = $this->schemaOrgBuilder->build($companyData, $rootPage->getAbsoluteUrl(), $logoUrl)))
        {
            return;
        }

        $jsonLdManager = $responseContext->get(JsonLdManager::class);
        $jsonLdManager
            ->getGraphForSchema(JsonLdManager::SCHEMA_ORG)
            ->add($jsonLdManager->createSchemaOrgTypeFromArray($schemaData))
        ;
    }
}
