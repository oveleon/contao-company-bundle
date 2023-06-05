<?php

/*
 * This file is part of Oveleon Recommendation Bundle.
 *
 * (c) https://www.oveleon.de/
 */

namespace Oveleon\ContaoCompanyBundle\EventListener\DataContainer;

use Contao\Automator;
use Contao\Config;
use Contao\Controller;
use Contao\CoreBundle\Exception\AccessDeniedException;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\Database;
use Contao\DataContainer;
use Contao\Date;
use Contao\Input;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\System;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Oveleon\ContaoRecommendationBundle\Model\RecommendationArchiveModel;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class DataContainerListener
{
    public function __construct(
        protected ContaoFramework $framework,
        protected Connection $connection,
        protected Security $security
    ){}

    public function clearEmptySocialMediaValue($varValue, ?DataContainer $dc)
    {
        if ('' === $varValue)
        {
            return $varValue;
        }

        if (!count($arrValue = StringUtil::deserialize($varValue, true)))
        {
            return '';
        }

        if (array_key_exists('type', $arrValue[0]))
        {
            if ('' === $arrValue[0]['type'])
            {
                return '';
            }
        }

        return $varValue;
    }
}
