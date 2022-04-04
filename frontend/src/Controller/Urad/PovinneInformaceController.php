<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PovinneInformaceController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/povinne-zverejnovane-informace', name: 'urad_povinne_informace')]
    public function __invoke(): Response
    {
        return $this->render('urad_povinne_informace.html.twig', [
            'dokumenty' => $this->contentProvider->getDokumentyPovinneInformaceData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
