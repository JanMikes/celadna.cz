<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Obec;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ObecController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obec', name: 'obec')]
    public function __invoke(): Response
    {
        return $this->render('obec.html.twig', [
            'obec' => $this->contentProvider->getObecData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
