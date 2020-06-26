<?php

/*
 * This file is part of Oveleon company bundle.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoCompanyBundle;

use Contao\BackendTemplate;
use Contao\FilesModel;
use Contao\Module;
use Contao\System;
use Patchwork\Utf8;

/**
 * Front end module "logo".
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class ModuleLogo extends Module
{
    /**
     * Files model of logo
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
        if (TL_MODE == 'BE')
        {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['logo'][0]) . ' ###';
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
    protected function compile()
    {
        $this->arrData['singleSRC'] = $this->objFile->path;
        $this->arrData['size'] = $this->imgSize;

        $this->addImageToTemplate($this->Template, $this->arrData, null, null, $this->objFile);
    }
}