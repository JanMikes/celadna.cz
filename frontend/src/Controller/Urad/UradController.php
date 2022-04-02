<?php

declare(strict_types=1);

namespace Celadna\Website\Controller\Urad;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UradController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad', name: 'urad')]
    public function __invoke(): Response
    {
        return $this->render('urad.html.twig', [
            'urad' => $this->contentProvider->getUradData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
