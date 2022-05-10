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

namespace Oveleon\ContaoCompanyBundle\EventListener;

use Contao\PageModel;
use Contao\System;
use Contao\StringUtil;
use Contao\CoreBundle\Framework\ContaoFramework;
use Oveleon\ContaoCompanyBundle\Company;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

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

    /**
     * @var ContaoFramework
     */
    private $framework;

    private RouterInterface $router;
    private RequestStack $requestStack;

    public function __construct(ContaoFramework $framework, RouterInterface $router, RequestStack $requestStack)
    {
        $this->framework = $framework;
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

	/**
	 * @return string|false
	 */
	public function __invoke(string $tag)
	{
		$elements = explode('::', $tag);
		$key = strtolower($elements[0]);

		if (\in_array($key, self::SUPPORTED_TAGS, true))
		{
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
        switch ($field)
        {
            case 'mailto':
            case 'email':
                $value = Company::get('email');

                if (empty($value))
                {
                    return '';
                }

                $strEmail = StringUtil::encodeEmail($value);

                if($field === 'mailto')
                {
                    $strEmail = '<a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;' . $strEmail . '" title="' . $strEmail . '">' . preg_replace('/\?.*$/', '', $strEmail) . '</a>';
                }

                return $strEmail;
            case 'mailto2':
            case 'email2':
                $value = Company::get('email2');

                if (empty($value))
                {
                    return '';
                }

                $strEmail = StringUtil::encodeEmail($value);

                if($field === 'mailto2')
                {
                    $strEmail = '<a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;' . $strEmail . '" title="' . $strEmail . '">' . preg_replace('/\?.*$/', '', $strEmail) . '</a>';
                }

                return $strEmail;
            case 'tel':
            case 'tel2':
                $value = Company::get($field === 'tel' ? 'phone' : 'phone2');

                if (empty($value))
                {
                    return '';
                }

                $strTel = preg_replace('/[^a-z0-9\+]/i', '', (string) $value);

                return '<a href="tel:' . $strTel . '" title="' . $value . '">' . $value . '</a>';
            case 'address':
                $arrAddress = array();

                $postal = Company::get('postal');
                $city = Company::get('city');
                $street = Company::get('street');

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
			case 'country':
				$value = Company::get('country');

				if (empty($value))
				{
					return '';
				}

				System::loadLanguageFile('countries');

				$strCountry = $GLOBALS['TL_LANG']['CNT'][$value];

				return $strCountry;
			case 'countrycode':
				return Company::get('country');
            case 'vcard_url':
                $pageId = 0;
                $request = $this->requestStack->getCurrentRequest();
                if (null !== $request) {
                    /** @var PageModel $page */
                    $page = $request->attributes->get('pageModel');
                    $pageId = $page->id;
                }

                return $this->router->generate('contao_company_vcard_download', ['redirect' => $pageId]);
        }

        return Company::get($field);
    }
}
