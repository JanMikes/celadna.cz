<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad\Dokumenty;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VyrocniZpravaController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/dokumenty-uradu/vyrocni-zprava', name: 'urad_dokumenty_vyrocni_zprava')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_vyrocni_zprava.html.twig', [
            'dokumenty' => $this->contentProvider->getDokumentyVyrocniZpravaData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
