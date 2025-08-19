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

namespace Oveleon\ContaoCompanyBundle;

use Contao\BackendTemplate;
use Contao\Module;
use Contao\StringUtil;
use Contao\System;

/**
 * Front end module "social media list".
 */
class ModuleSocialMediaList extends Module
{
    /**
     * Social media items.
     * @var array
     */
    protected $arrItems;

    /**
     * Template.
     * @var string
     */
    protected $strTemplate = 'mod_socialmedialist';

    /**
     * Display a wildcard in the back end.
     *
     * @return string
     */
    public function generate()
    {
        $container = System::getContainer();

        $request = $container->get('request_stack')->getCurrentRequest();

        if ($request && $container->get('contao.routing.scope_matcher')->isBackendRequest($request))
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . $GLOBALS['TL_LANG']['FMD']['socialmedialist'][0] . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = StringUtil::specialcharsUrl($container->get('router')->generate('contao_backend', [
                'do' => 'themes',
                'table' => 'tl_module',
                'act' => 'edit',
                'id' => $this->id,
            ]));

            return $objTemplate->parse();
        }

        $this->loadLanguageFile('tl_company_socials');

        $this->arrItems = [];
        $arrSocialMedia = StringUtil::deserialize(System::getContainer()->get('contao_company.company')->get('socialmedia'), true);

        foreach ($arrSocialMedia as $item)
        {
            if (empty($item['type']))
            {
                continue;
            }
            if (empty($item['url']))
            {
                continue;
            }
            $this->arrItems[] = [
                'url' => $item['url'],
                'class' => $item['type'],
                'title' => $GLOBALS['TL_LANG']['tl_company_socials'][$item['type']],
                'label' => $GLOBALS['TL_LANG']['tl_company_socials'][$item['type']],
            ];
        }

        if ($this->arrItems === [])
        {
            return '';
        }

        return parent::generate();
    }

    /**
     * Generate the module.
     */
    protected function compile(): void
    {
        $this->Template->items = $this->arrItems;
    }
}

class_alias(ModuleSocialMediaList::class, 'ModuleSocialMediaList');
