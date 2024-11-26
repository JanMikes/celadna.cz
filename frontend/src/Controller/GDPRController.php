<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GDPRController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/gdpr', name: 'gdpr')]
    public function __invoke(): Response
    {
        return $this->render('gdpr.html.twig', [
            'gdpr' => $this->contentProvider->getGdprData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
