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

namespace Oveleon\ContaoCompanyBundle;

use Contao\BackendTemplate;
use Contao\Environment;
use Contao\FilesModel;
use Contao\Module;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

/**
 * Front end module "logo".
 *
 * @property integer 	$id
 * @property string		$headline
 *
 * @author Fabian Ekert <https://github.com/eki89>
 * @author Sebastian Zoglowek <https://github.com/zoglo>
 */
class ModuleLogo extends Module
{
    protected ?FilesModel $objFile = null;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_logo';

    /**
     * Display a wildcard in the back end
     */
    public function generate(): string
    {
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['FMD']['logo'][0] . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = StringUtil::specialcharsUrl(System::getContainer()->get('router')->generate('contao_backend', ['do'=>'themes', 'table'=>'tl_module', 'act'=>'edit', 'id'=>$this->id]));

            return $objTemplate->parse();
        }

        if (
            ('' === ($singleSRC = System::getContainer()->get('contao_company.company')->get('logo'))) ||
            (null === ($this->objFile = FilesModel::findByUuid($singleSRC)) || !is_file(System::getContainer()->getParameter('kernel.project_dir') . '/' . $this->objFile->path))
        ) {
            return '';
        }

        return parent::generate();
    }

    protected function compile(): void
    {
        /** @var PageModel $objPage */
        global $objPage;

        $container = System::getContainer();

        $companyName   = $container->get('contao_company.company')->get('name');
        $figureBuilder = $container
            ->get('contao.image.studio')
            ->createFigureBuilder()
            ->from($this->objFile->path)
            ->setSize($this->imgSize);

        if (null !== ($figure = $figureBuilder->buildIfResourceExists()))
        {
            $figure->applyLegacyTemplateData($this->Template);
        }

        // Create rootHref URL
        $strPageUrl = Environment::get('url');

        // Append preview script within preview mode
        if ($this->isFrontendPreview())
        {
            $strPageUrl .= $container->getParameter('contao.preview_script') ?? '';
        }

        // Contao 4.13 legacy routing fallback + contao 5.x compatibility
        try {
            $prependLocale = $container->getParameter('contao.prepend_locale');
        } catch (ParameterNotFoundException) {
            $prependLocale = '';
        }

        // Legacy routing
        if ($prependLocale)
        {
            $strPageUrl .= '/' . $objPage->language;
        }
        elseif ((bool) $objPage->urlPrefix)
        {
            $strPageUrl .= '/' . $objPage->urlPrefix;
        }

        $strPageUrl .= '/';

        // Override title tag with company name if it is set, otherwise set page URI
        $strCompanyName = empty($companyName) ? $strPageUrl : $companyName;

        $this->Template->rootHref = $strPageUrl;
        $this->Template->title = $strCompanyName;
    }

    protected function isFrontendPreview(): bool
    {
        $container = System::getContainer();
        $request = $container->get('request_stack')->getCurrentRequest();
        $tokenChecker = $container->get('contao.security.token_checker');
        return !(null === $request || !$request->attributes->get('_preview', false) || !$tokenChecker->canAccessPreview());
    }
}

class_alias(ModuleLogo::class, 'ModuleLogo');
