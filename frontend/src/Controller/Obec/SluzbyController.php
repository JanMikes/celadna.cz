<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Obec;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SluzbyController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obec/sluzby', name: 'obec_sluzby')]
    public function __invoke(): Response
    {
        return $this->render('obec_sluzby.html.twig', [
            'sluzby' => $this->contentProvider->getSluzbyData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
