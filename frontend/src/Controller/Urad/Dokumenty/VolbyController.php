<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad\Dokumenty;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class VolbyController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/dokumenty-uradu/volby', name: 'urad_dokumenty_volby')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_volby.html.twig', [
            'dokumenty' => $this->contentProvider->getDokumentyVolbyData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
