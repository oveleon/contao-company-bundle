<?php

/*
 * This file is part of Oveleon company bundle.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoCompanyBundle;

use Contao\BackendTemplate;
use Contao\Module;
use Contao\StringUtil;
use Patchwork\Utf8;

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
        if (TL_MODE == 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['socialmedialist'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $this->loadLanguageFile('tl_settings');

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
                'title' => $GLOBALS['TL_LANG']['tl_settings'][$item['type']],
                'label' => $GLOBALS['TL_LANG']['tl_settings'][$item['type']]
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