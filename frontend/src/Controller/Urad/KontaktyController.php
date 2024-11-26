<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class KontaktyController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obec/kontakty', name: 'urad_kontakty')]
    public function __invoke(): Response
    {
        return $this->render('urad_kontakty.html.twig',[
            'kontakty' => $this->contentProvider->getKontaktyData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
