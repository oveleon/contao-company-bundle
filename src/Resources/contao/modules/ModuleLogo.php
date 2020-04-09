<?php

/*
 * This file is part of Oveleon company bundle.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoCompanyBundle;

use Contao\FilesModel;
use Patchwork\Utf8;

/**
 * Front end module "logo".
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class ModuleLogo extends \Module
{
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
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['FMD']['logo'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }

    /**
     * Generate the module
     */
    protected function compile()
    {
        $singleSRC = Company::get('logo');

        if ($singleSRC == '')
        {
            return '';
        }

        $objFile = \FilesModel::findByUuid($singleSRC);

        if ($objFile === null || !is_file(\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFile->path))
        {
            return '';
        }

        $this->arrData['singleSRC'] = $objFile->path;
        $this->arrData['size'] = $this->imgSize;

        $this->addImageToTemplate($this->Template, $this->arrData, null, null, $objFile);

        $arrCompanyLogos = \StringUtil::deserialize($this->companyLogo, true);

        $container = \System::getContainer();

        foreach ($arrCompanyLogos as $companyLogo)
        {
            $objFile = \FilesModel::findByUuid($companyLogo['imageSRC']);

            $picture = $container->get('contao.image.picture_factory')->create($container->getParameter('kernel.project_dir') . '/' . $objFile->path, array($companyLogo['width'], '', 'proportional'));
        }
    }
}