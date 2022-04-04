<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomepageController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/', name: 'homepage')]
    public function __invoke(): Response
    {
        return $this->render('homepage.html.twig', [
            'aktuality' => $this->contentProvider->getAktualityData(limit: 4),
            'uredni_deska' => $this->contentProvider->getUredniDeskyData(limit: 4),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
