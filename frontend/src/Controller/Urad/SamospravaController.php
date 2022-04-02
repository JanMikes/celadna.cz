<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SamospravaController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obec/samosprava', name: 'urad_samosprava')]
    public function __invoke(): Response
    {
        return $this->render('urad_samosprava.html.twig', [
            'kategorie_samospravy' => $this->contentProvider->getSamospravaData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
