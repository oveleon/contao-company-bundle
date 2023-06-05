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
use Contao\Module;
use Contao\StringUtil;
use Contao\System;

/**
 * Front end module "social media list".
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class ModuleSocialMediaList extends Module
{
    /**
     * Social media items
     * @var array
     */
    protected $arrItems;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_socialmedialist';

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
		    $objTemplate->wildcard = '### ' . mb_strtoupper($GLOBALS['TL_LANG']['FMD']['socialmedialist'][0], 'UTF-8') . ' ###';
		    $objTemplate->title = $this->headline;
		    $objTemplate->id = $this->id;
		    $objTemplate->link = $this->name;
		    $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

		    return $objTemplate->parse();
	    }

        $this->loadLanguageFile('tl_company_socials');

        $this->arrItems = array();
        $arrSocialMedia = StringUtil::deserialize(Company::get('socialmedia'), true);

        foreach ($arrSocialMedia as $item)
        {
            if (empty($item['type']) || empty($item['url']))
            {
                continue;
            }

            $this->arrItems[] = array
            (
                'url'   => $item['url'],
                'class' => $item['type'],
                'title' => $GLOBALS['TL_LANG']['tl_company_socials'][$item['type']],
                'label' => $GLOBALS['TL_LANG']['tl_company_socials'][$item['type']]
            );
        }

        if (!count($this->arrItems))
        {
            return '';
        }

        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $this->Template->items = $this->arrItems;
    }
}
