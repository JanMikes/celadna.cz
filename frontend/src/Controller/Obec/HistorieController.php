<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Obec;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HistorieController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obec/historie', name: 'obec_historie')]
    public function __invoke(): Response
    {
        return $this->render('obec_historie.html.twig', [
            'historie_graficke_pasy' => $this->contentProvider->getHistorieData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
