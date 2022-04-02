<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Obec;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RestauraceController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obec/restaurace', name: 'obec_restaurace')]
    public function __invoke(): Response
    {
        return $this->render('obec_restaurace.html.twig', [
            'restaurace' => $this->contentProvider->getRestauraceData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
