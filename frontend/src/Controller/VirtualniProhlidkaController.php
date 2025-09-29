<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VirtualniProhlidkaController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/virtualni-prohlidka', name: 'virtualni_prohlidka')]
    public function __invoke(): Response
    {
        return $this->render('virtualni_prohlidka.html.twig', [
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
