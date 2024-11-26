<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PristupnostController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/prohlaseni-o-pristupnosti', name: 'pristupnost')]
    public function __invoke(): Response
    {
        return $this->render('pristupnost.html.twig', [
            'pristupnost' => $this->contentProvider->getPristupnostData(),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
