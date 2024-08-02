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

use Contao\StringUtil;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

/**
 * Handles insert tags for company details.
 */
class InsertTagsListener
{
    private const SUPPORTED_TAGS = [
        'company',
    ];

    public function __construct(
        private readonly RouterInterface $router,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function __invoke(string $tag, bool $useCache, $cacheValue, array $flags): string|false
    {
        $elements = explode('::', $tag);
        $key = strtolower($elements[0]);

        if (\in_array($key, self::SUPPORTED_TAGS, true))
        {
            return $this->replaceCompanyInsertTags($elements[1]);
        }

        return false;
    }

    /**
     * Replaces a company-related insert tag.
     */
    private function replaceCompanyInsertTags(string $field): string
    {
        $company = System::getContainer()->get('contao_company.company');

        switch ($field)
        {
            case 'mailto':
            case 'email':
                if (empty($value = $company->get('email')))
                {
                    return '';
                }

                $strEmail = StringUtil::encodeEmail($value);

                return 'mailto' === $field ? '<a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;'.$strEmail.'" title="'.$strEmail.'">'.preg_replace('/\?.*$/', '', $strEmail).'</a>' : $strEmail;

            case 'mailto2':
            case 'email2':
                if (empty($value = $company->get('email2')))
                {
                    return '';
                }

                $strEmail = StringUtil::encodeEmail($value);

                return 'mailto2' === $field ? '<a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;'.$strEmail.'" title="'.$strEmail.'">'.preg_replace('/\?.*$/', '', $strEmail).'</a>' : $strEmail;

            case 'tel':
            case 'tel2':
                return empty($value = $company->get('tel' === $field ? 'phone' : 'phone2')) ? '' : '<a href="tel:'.preg_replace('/[^a-z0-9\+]/i', '', (string) $value).'" title="'.$value.'">'.$value.'</a>';

            case 'address':
                $arrAddress = [];

                if ((bool) ($street = $company->get('street')))
                {
                    $arrAddress[] = $street;
                }

                $postal = $company->get('postal');
                $city = $company->get('city');

                if ((bool) $postal && (bool) $city)
                {
                    $arrAddress[] = $postal.' '.$city;
                }
                elseif ((bool) $postal)
                {
                    $arrAddress[] = $postal;
                }
                elseif ((bool) $city)
                {
                    $arrAddress[] = $city;
                }

                return implode(', ', $arrAddress);

            case 'country':
                return empty($value = $company->get('country')) ? '' : System::getContainer()->get('contao.intl.countries')->getCountries()[strtoupper((string) $value)] ?? $value;

            case 'countrycode':
                return $company->get('country') ?? '';

            case 'vcard_url':
                $pageId = (($request = $this->requestStack->getCurrentRequest()) instanceof Request) ? $request->attributes->get('pageModel')->id : 0;

                return $this->router->generate('contao_company_vcard_download', ['page' => $pageId]);

            default:
                return (string) $company->get($field) ?? '';
        }
    }
}
