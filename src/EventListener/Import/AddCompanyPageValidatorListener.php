<?php

namespace Oveleon\ContaoCompanyBundle\EventListener\Import;

use Contao\Controller;
use Contao\FilesModel;
use Contao\PageModel;
use Oveleon\ProductInstaller\Import\Prompt\FormPromptType;
use Oveleon\ProductInstaller\Import\Validator;
use Oveleon\ProductInstaller\Import\TableImport;
use Oveleon\ContaoCompanyBundle\Import\Validator\CompanyPageValidator;

class AddCompanyPageValidatorListener
{
    public function addValidators(): void
    {
        // Connects jumpTo pages
        Validator::addValidator(CompanyPageValidator::getTrigger(), [AddCompanyPageValidatorListener::class, 'setCompanyLogoConnection']);
    }

    /**
     * Handles company logo image (companyLogo) in page elements.
     *
     * @category BEFORE_IMPORT_ROW
     */
    public static function setCompanyLogoConnection(array &$row, TableImport $importer): ?array
    {
        if(!$importer->hasValue($row, 'companyLogo'))
        {
            return null;
        }

        // Get translator
        $translator = Controller::getContainer()->get('translator');

        return $importer->useIdentifierConnectionLogic($row, 'companyLogo', PageModel::getTable(), FilesModel::getTable(), [
            'class'       => 'w50',
            'isFile'      => true,
            'widget'      => FormPromptType::FILE,
            'popupTitle'  => $translator->trans('setup.prompt.company.companyLogo.label', [], 'setup'),
            'label'       => $translator->trans('setup.prompt.company.companyLogo.label', [], 'setup'),
            'description' => $translator->trans('setup.prompt.company.companyLogo.description', [], 'setup'),
        ]);
    }
}
