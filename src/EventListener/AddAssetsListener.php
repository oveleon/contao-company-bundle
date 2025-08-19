<?php

declare(strict_types=1);

namespace Oveleon\ContaoCompanyBundle\EventListener;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

#[AsEventListener]
class AddAssetsListener
{
    public function __construct(
        private readonly ScopeMatcher $scopeMatcher,
    ) {
    }

    public function __invoke(RequestEvent $event): void
    {
        if ($this->scopeMatcher->isBackendMainRequest($event))
        {
            $GLOBALS['TL_CSS'][] = 'bundles/contaocompany/css/column_wizard.css|static';
        }
    }
}
