<?php

declare(strict_types=1);

namespace Oveleon\ContaoCompanyBundle\EventSubscriber;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class KernelRequestSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected ScopeMatcher $scopeMatcher,
        protected Security $security,
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => 'onKernelRequest'];
    }

    public function onKernelRequest(RequestEvent $e): void
    {
        $request = $e->getRequest();

        if ($this->scopeMatcher->isBackendRequest($request))
        {
            $GLOBALS['TL_CSS'][] = 'bundles/contaocompany/css/backend.css|static';
            $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/contaocompany/scripts/widget.js|static';
        }
    }
}
