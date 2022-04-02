<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Obec;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class VyletyController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obec/vylety', name: 'obec_vylety')]
    public function __invoke(): Response
    {
        return $this->render('obec_vylety.html.twig', [
            'vylety_graficke_pasy' => $this->contentProvider->getVyletyData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
