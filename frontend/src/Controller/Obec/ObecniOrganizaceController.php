<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Obec;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ObecniOrganizaceController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obec/obecni-organizace', name: 'obec_obecni_organizace')]
    public function __invoke(): Response
    {
        return $this->render('obec_obecni_organizace.html.twig', [
            'organizace_graficke_pasy' => $this->contentProvider->getObecniOrganizaceData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
