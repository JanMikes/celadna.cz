<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomepageController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/', 'homepage')]
    public function __invoke(): Response
    {
        return $this->render('homepage.html.twig', [
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
