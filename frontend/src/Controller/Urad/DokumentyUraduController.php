<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DokumentyUraduController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/dokumenty-uradu', name: 'urad_dokumenty_uradu')]
    public function __invoke(): Response
    {
        return $this->render('urad_dokumenty_uradu.html.twig',[
            'dokumenty_uradu' => $this->contentProvider->getDokumentyUraduData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
