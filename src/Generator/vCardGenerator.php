<?php

namespace Oveleon\ContaoCompanyBundle\Generator;

use Contao\FilesModel;
use Contao\PageModel;
use Contao\System;
use JeroenDesloovere\VCard\VCard;
use Oveleon\ContaoCompanyBundle\Company;
use Symfony\Component\Filesystem\Path;

class vCardGenerator
{
    private ?VCard $vCard;
    private Company $company;

    public function __construct()
    {
        $this->vCard = null;
    }

    /**
     * Generate a vcard with the given company values.
     *
     * @param PageModel $pageModel
     *
     * @return $this
     */
    public function createCard(PageModel $pageModel): self
    {
        // Init company with current page model
        $this->company = new Company();
        $this->company->initialize($pageModel, null, null);

        // Generate the vcard
        $this->vCard = new VCard();
        $this
            ->addName()
            ->addCompany()
            ->addAddress()
            ->addEmail()
            ->addPhone()
            ->addFax()
            ->addLogo()
        ;

        return $this;
    }

    /**
     * Get the content of the vcard as string.
     *
     * @return string
     *
     * @throws \Exception
     */
    public function getContent(): string
    {
        if (null === $this->vCard) {
            throw new \Exception('You must create a v-card first!');
        }

        return $this->vCard->getOutput();
    }

    /**
     * Get the correct headers to be able to download the vcard.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->vCard->getHeaders(true);
    }

    private function addName(): self
    {
        $this->vCard->addName($this->company::get('name'));

        return $this;
    }

    private function addCompany(): self
    {
        $this->vCard->addCompany($this->company::get('name'));

        return $this;
    }

    private function addAddress(): self
    {
        $street = $this->company::get('street') ?: null;
        $city = $this->company::get('city') ?: null;
        $state = $this->company::get('state') ?: null;
        $zip = $this->company::get('postal') ?: null;
        $country = $this->company::get('country') ?: null;
        $type = 'WORK;POSTAL';
        if (null === $street && null === $city && null === $state && null === $zip && null === $country) {
            return $this;
        }

        $this->vCard->addAddress(null, null, $street, $city, $state, $zip, $country, $type);

        return $this;
    }

    private function addEmail(): self
    {
        $mail = $this->company::get('email') ?: null;
        if (null === $mail) {
            $mail = $this->company::get('email2') ?: null;
        }
        if (null === $mail) {
            return $this;
        }

        $this->vCard->addEmail($mail, 'WORK');

        return $this;
    }

    private function addPhone(): self
    {
        $phone = $this->company::get('phone') ?: null;
        if (null === $phone) {
            $phone = $this->company::get('phone2') ?: null;
        }
        if (null === $phone) {
            return $this;
        }

        $this->vCard->addPhoneNumber($phone, 'WORK');

        return $this;
    }

    private function addFax(): self
    {
        $fax = $this->company::get('fax') ?: null;
        if (null === $fax) {
            return $this;
        }

        $this->vCard->addPhoneNumber($fax, 'FAX');

        return $this;
    }

    private function addLogo(): self
    {
        $uuid = $this->company::get('logo') ?: null;
        if (null === $uuid) {
            return $this;
        }

        $file = FilesModel::findByUuid($uuid);
        if (null === $file) {
            return $this;
        }

        $projectDir = System::getContainer()->getParameter('kernel.project_dir');
        $this->vCard->addLogo(Path::makeAbsolute($file->path, $projectDir));

        return $this;
    }
}
