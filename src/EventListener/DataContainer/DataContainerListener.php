<?php

declare(strict_types=1);

/*
 * This file is part of Oveleon Recommendation Bundle.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoCompanyBundle\EventListener\DataContainer;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\DataContainer;
use Contao\StringUtil;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\Security;

class DataContainerListener
{
    public function __construct(
        protected ContaoFramework $framework,
        protected Connection $connection,
        protected Security $security,
    ) {
    }

    public function clearEmptySocialMediaValue($varValue, DataContainer|null $dc)
    {
        if ('' === $varValue)
        {
            return $varValue;
        }

        if (0 === \count($arrValue = StringUtil::deserialize($varValue, true)))
        {
            return '';
        }

        if (\array_key_exists('type', $arrValue[0]) && '' === $arrValue[0]['type'])
        {
            return '';
        }

        return $varValue;
    }
}
