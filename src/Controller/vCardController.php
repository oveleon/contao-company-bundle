<?php

namespace Oveleon\ContaoCompanyBundle\Controller;

use Contao\PageModel;
use Oveleon\ContaoCompanyBundle\Generator\vCardGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(defaults={"_scope" = "frontend"})
 */
class vCardController extends AbstractController
{
    public function __construct(
        private readonly vCardGenerator $generator
    ){}

    /**
     * @Route("/company/vcard/download", name="contao_company_vcard_download")
     *
     * @throws \Exception
     */
    public function download(Request $request): Response
    {
        // Try to load the current contao page
        $pageId = (int) $request->query->get('page');

        if (null === ($pageModel = PageModel::findById($pageId)))
        {
            throw new \Exception('Could not load correct redirect page');
        }

        try {
            // Load all details of the page to have access to rootId
            $pageModel->loadDetails();

            // Generate the vcard
            $vcf = $this->generator
                ->createCard($pageModel)
                ->getContent();

            $headers = $this->generator->getHeaders();
        } catch (\Exception $e) {
            $vcf = '';
            $headers = [];
        }

        return new Response($vcf, 200, $headers);
    }
}
