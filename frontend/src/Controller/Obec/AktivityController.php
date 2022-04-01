<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Obec;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AktivityController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obec/aktivity', 'obec_aktivity')]
    public function __invoke(): Response
    {
        return $this->render('obec_aktivity.html.twig', [
            'aktivity_graficke_pasy' => $this->contentProvider->getAktivityData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
