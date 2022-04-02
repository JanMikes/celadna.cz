<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class MapaStranekController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/mapa-stranek', name: 'mapa_stranek')]
    public function __invoke(): Response
    {
        return $this->render('mapa_stranek.html.twig', [
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
