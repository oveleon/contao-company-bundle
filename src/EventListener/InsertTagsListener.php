<?php

declare(strict_types=1);

/*
 * This file is part of Oveleon company bundle.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoCompanyBundle\EventListener;

use Contao\CoreBundle\Framework\ContaoFrameworkInterface;

/**
 * Handles insert tags for company details.
 *
 * @author Fabian Ekert <https://github.com/eki89>
 */
class InsertTagsListener
{
    private const SUPPORTED_TAGS = [
        'company'
    ];

    private const SUPPORTED_FIELDS = [
        'companyName',
        'companyStreet',
        'companyPostal',
        'companyCity',
        'companyState',
        'companyCountry',
        'companyPhone',
        'companyPhone2',
        'companyFax',
        'companyEmail',
        'companyWebsite'
    ];

    /**
     * @var ContaoFrameworkInterface
     */
    private $framework;

    /**
     * @var bool $initialized
     */
    private static $initialized = false;

    /**
     * @var \PageModel|null $objRootPage
     */
    private static $objRootPage;

    /**
     * Constructor.
     *
     * @param ContaoFrameworkInterface $framework
     */
    public function __construct(ContaoFrameworkInterface $framework)
    {
        $this->framework = $framework;
    }

    /**
     * Replaces company insert tags.
     *
     * @param string $tag
     *
     * @return string|false
     */
    public function onReplaceInsertTags(string $tag)
    {
        $elements = explode('::', $tag);
        $key = strtolower($elements[0]);

        if (\in_array($key, self::SUPPORTED_TAGS, true)) {
            return $this->replaceCompanyInsertTags($key, $elements[1]);
        }

        return false;
    }

    /**
     * Replaces a company-related insert tag.
     *
     * @param string $insertTag
     * @param string $field
     *
     * @return string
     */
    private function replaceCompanyInsertTags($insertTag, $field)
    {
        if (!static::$initialized)
        {
            $this->framework->initialize();

            $this->loadDetails();

            static::$initialized = true;
        }

        switch ($field)
        {
            case 'mailto':
            case 'email':
                $value = $this->getValue('email');

                if (empty($value))
                {
                    return '';
                }

                $strEmail = \StringUtil::encodeEmail($value);

                if($field === 'mailto')
                {
                    $strEmail = '<a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;' . $strEmail . '" title="' . $strEmail . '">' . preg_replace('/\?.*$/', '', $strEmail) . '</a>';
                }

                return $strEmail;
            case 'tel':
            case 'tel2':
                $value = $this->getValue($field === 'tel' ? 'phone' : 'phone2');

                if (empty($value))
                {
                    return '';
                }

                $strTel = preg_replace('/[^a-z0-9\+]/i', '', $value);

                return '<a href="tel:' . $strTel . '" title="' . $value . '">' . $value . '</a>';
            case 'address':
                $arrAddress = array();

                $postal = $this->getValue('postal');
                $city = $this->getValue('city');
                $street = $this->getValue('street');

                if ($street)
                {
                    $arrAddress[] = $street;
                }

                if($postal && $city)
                {
                    $arrAddress[] = $postal . ' ' . $city;
                }
                elseif ($postal)
                {
                    $arrAddress[] = $postal;
                }
                elseif ($city)
                {
                    $arrAddress[] = $city;
                }

                return implode(', ', $arrAddress);
        }

        return $this->getValue($field);
    }

    /**
     * Get value by root page or config
     *
     * @param string $field
     *
     * @return string
     */
    private function getValue($field)
    {
        $fieldName = 'company'.ucfirst(strtolower($field));
        $value = '';

        if (\in_array($fieldName, self::SUPPORTED_FIELDS, true))
        {
            $value = static::$objRootPage->{$fieldName};

            if (empty($value))
            {
                $value = \Config::get($fieldName);
            }
        }

        return $value;
    }

    /**
     * Load root page details
     */
    private function loadDetails()
    {
        global $objPage;
        $objRoot = $objPage->loadDetails();

        /** @var \PageModel $adapter */
        $adapter = $this->framework->getAdapter(\PageModel::class);

        static::$objRootPage = $adapter->findByPk($objRoot->rootId);
    }
}
