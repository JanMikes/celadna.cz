<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AktualityController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}

    #[Route('/aktuality', name: 'aktuality')]
    public function __invoke(): Response
    {
        return $this->render('aktuality.html.twig', [
            'aktuality' => $this->contentProvider->getAktualityData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
