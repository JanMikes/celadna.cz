<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class StrukturaUraduController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/struktura-uradu', name: 'urad_struktura_uradu')]
    public function __invoke(): Response
    {
        return $this->render('urad_struktura_uradu.html.twig', [
            'struktura_uradu' => $this->contentProvider->getStrukturaUraduData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
