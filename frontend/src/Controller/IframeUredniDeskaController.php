<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IframeUredniDeskaController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/iframe/obecni-urad/uredni-deska', name: 'iframe_uredni_deska')]
    public function __invoke(): Response
    {
        return $this->render('iframe_uredni_deska.html.twig', [
            'uredni_desky' => $this->contentProvider->getUredniDeskyData(shouldHideIfExpired: true),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
