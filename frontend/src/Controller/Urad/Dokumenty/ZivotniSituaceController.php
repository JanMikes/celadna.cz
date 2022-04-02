<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad\Dokumenty;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ZivotniSituaceController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/dokumenty-uradu/zivotni-situace', name: 'urad_dokumenty_zivotni_situace')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_zivotni_situace.html.twig', [
            'dokumenty' => $this->contentProvider->getDokumentyZivotniSituaceData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
