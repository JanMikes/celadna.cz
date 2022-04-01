<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad\Dokumenty;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class FormulareController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/dokumenty-uradu/formulare', 'urad_dokumenty_formulare')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_formulare.html.twig', [
            'dokumenty' => $this->contentProvider->getDokumentyFormulareData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
