<?php

declare(strict_types=1);

/*
 * This file is part of Oveleon Recommendation Bundle.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoCompanyBundle\EventListener\DataContainer;

use Contao\DataContainer;
use Contao\StringUtil;

class DataContainerListener
{
    public static function clearEmptySocialMediaValue($varValue, DataContainer|null $dc)
    {
        if ($varValue === '')
        {
            return $varValue;
        }

        if (\count($arrValue = StringUtil::deserialize($varValue, true)) === 0)
        {
            return '';
        }

        if (\array_key_exists('type', $arrValue[0]) && $arrValue[0]['type'] === '')
        {
            return '';
        }

        return $varValue;
    }
}
