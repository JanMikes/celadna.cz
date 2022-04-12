<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UredniDeskaRokFilterController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/uredni-deska/rok/{rok}', name: 'uredni_deska_rok_filter')]
    public function __invoke(string $rok): Response
    {
        return $this->render('uredni_deska.html.twig', [
            'uredni_desky' => $this->contentProvider->getUredniDeskyData(shouldHideIfExpired: true),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
