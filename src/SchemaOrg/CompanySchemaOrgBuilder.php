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

namespace Oveleon\ContaoCompanyBundle\SchemaOrg;

final class CompanySchemaOrgBuilder
{
    /**
     * @param array<string, mixed> $companyData
     *
     * @return array<string, mixed>|null
     */
    public function build(array $companyData, string $rootUrl, string|null $logoUrl = null): array|null
    {
        if (null === ($name = $this->normalizeString($companyData['name'] ?? null)))
        {
            return null;
        }

        $rootUrl = rtrim($rootUrl, '/') . '/';

        $organization = [
            '@type' => 'Organization',
            '@id' => $rootUrl . '#/schema/organization',
            'name' => $name,
            'url' => $rootUrl,
        ];

        if ([] !== ($address = $this->buildAddress($companyData)))
        {
            $organization['address'] = $address;
        }

        if ([] !== ($telephone = $this->uniqueStrings([$companyData['phone'] ?? null, $companyData['phone2'] ?? null])))
        {
            $organization['telephone'] = $this->oneOrMany($telephone);
        }

        if (null !== ($fax = $this->normalizeString($companyData['fax'] ?? null)))
        {
            $organization['faxNumber'] = $fax;
        }

        $emails = array_values(array_filter(
            $this->uniqueStrings([$companyData['email'] ?? null, $companyData['email2'] ?? null]),
            static fn (string $email): bool => false !== filter_var($email, FILTER_VALIDATE_EMAIL),
        ));

        if ([] !== $emails)
        {
            $organization['email'] = $this->oneOrMany($emails);
        }

        if (null !== $logoUrl && $this->isHttpUrl($logoUrl))
        {
            $organization['logo'] = $logoUrl;
        }

        if ([] !== ($sameAs = $this->buildSameAs($companyData['socialmedia'] ?? [])))
        {
            $organization['sameAs'] = $sameAs;
        }

        return $organization;
    }

    /**
     * @param array<string, mixed> $companyData
     *
     * @return array<string, string>
     */
    private function buildAddress(array $companyData): array
    {
        $mapping = [
            'street' => 'streetAddress',
            'postal' => 'postalCode',
            'city' => 'addressLocality',
            'state' => 'addressRegion',
            'country' => 'addressCountry',
        ];
        $address = [];

        foreach ($mapping as $companyField => $schemaField)
        {
            if (null === ($value = $this->normalizeString($companyData[$companyField] ?? null)))
            {
                continue;
            }

            $address[$schemaField] = 'country' === $companyField ? strtoupper($value) : $value;
        }

        if ([] !== $address)
        {
            $address = ['@type' => 'PostalAddress'] + $address;
        }

        return $address;
    }

    /**
     * @return array<string>
     */
    private function buildSameAs(mixed $socialMedia): array
    {
        if (!\is_array($socialMedia))
        {
            return [];
        }

        $urls = [];

        foreach ($socialMedia as $item)
        {
            if (
                !\is_array($item)
                || null === $this->normalizeString($item['type'] ?? null)
                || null === ($url = $this->normalizeString($item['url'] ?? null))
            )
            {
                continue;
            }

            if ($this->isHttpUrl($url))
            {
                $urls[] = $url;
            }
        }

        return array_values(array_unique($urls));
    }

    /**
     * @param array<mixed> $values
     *
     * @return array<string>
     */
    private function uniqueStrings(array $values): array
    {
        $values = array_map($this->normalizeString(...), $values);

        return array_values(array_unique(array_filter($values, static fn (string|null $value): bool => null !== $value)));
    }

    private function normalizeString(mixed $value): string|null
    {
        if (!\is_scalar($value))
        {
            return null;
        }

        $value = trim((string) $value);

        return '' === $value ? null : $value;
    }

    private function isHttpUrl(string $url): bool
    {
        return false !== filter_var($url, FILTER_VALIDATE_URL)
            && \in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'], true);
    }

    /**
     * @param non-empty-array<string> $values
     *
     * @return string|array<string>
     */
    private function oneOrMany(array $values): string|array
    {
        return 1 === \count($values) ? $values[0] : $values;
    }
}
