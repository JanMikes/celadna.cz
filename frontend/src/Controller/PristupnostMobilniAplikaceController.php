<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PristupnostMobilniAplikaceController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/prohlaseni-o-pristupnosti-mobilni-aplikace', name: 'pristupnost_mobilni_app')]
    public function __invoke(): Response
    {
        return $this->render('pristupnost.html.twig', [
            'pristupnost' => $this->contentProvider->getPristupnostAppData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
