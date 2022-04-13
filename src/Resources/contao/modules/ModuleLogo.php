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
use Contao\System;

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
    /**
     * Files model of logo
     *
     * @var FilesModel
     */
    protected $objFile;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_logo';

    /**
     * Display a wildcard in the back end
     *
     * @return string
     */
    public function generate()
    {
	    $request = System::getContainer()->get('request_stack')->getCurrentRequest();

	    if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request))
	    {
		    $objTemplate = new BackendTemplate('be_wildcard');
		    $objTemplate->wildcard = '### ' . mb_strtoupper($GLOBALS['TL_LANG']['FMD']['logo'][0], 'UTF-8') . ' ###';
		    $objTemplate->title = $this->headline;
		    $objTemplate->id = $this->id;
		    $objTemplate->link = $this->name;
		    $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

		    return $objTemplate->parse();
	    }

        $singleSRC = Company::get('logo');

        if ($singleSRC == '')
        {
            return '';
        }

        $this->objFile = FilesModel::findByUuid($singleSRC);

        if ($this->objFile === null || !is_file(System::getContainer()->getParameter('kernel.project_dir') . '/' . $this->objFile->path))
        {
            return '';
        }

        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile(): void
    {
        /** @var PageModel $objPage */
        global $objPage;

        $this->arrData['singleSRC'] = $this->objFile->path;
        $this->arrData['size'] = $this->imgSize;

        $this->addImageToTemplate($this->Template, $this->arrData, null, null, $this->objFile);

		// Create rootHref URL
        $strPageUrl = Environment::get('url');
        $prependLocale = System::getContainer()->getParameter('contao.prepend_locale');

        if($prependLocale)
        {
	        $strPageUrl .= '/' . $objPage->language;
        }
        // consider urlPrefix with disabled legacy routing (Contao 4.10 and up)
        else if(!!$objPage->urlPrefix)
        {
            $strPageUrl .= '/' . $objPage->urlPrefix;
        }

	    $strPageUrl .= '/';

		// Set URI as title tag
		$strCompanyName = $strPageUrl;

	    // Override title tag with company name if it is set
	    if (!empty(Company::get('name')))
		{
			$strCompanyName = Company::get('name');
	    }

	    $this->Template->rootHref = $strPageUrl;
	    $this->Template->title = $strCompanyName;
    }
}
