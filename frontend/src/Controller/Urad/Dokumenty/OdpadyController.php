<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad\Dokumenty;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class OdpadyController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/dokumenty-uradu/odpady', name: 'urad_dokumenty_odpady')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_odpady.html.twig', [
            'dokumenty' => $this->contentProvider->getDokumentyOdpadyData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
