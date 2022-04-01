<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Obec;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class OrganizaceController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obec/organizace', 'obec_organizace')]
    public function __invoke(): Response
    {
        return $this->render('obec_organizace.html.twig', [
            'organizace_graficke_pasy' => $this->contentProvider->getOrganizaceData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
