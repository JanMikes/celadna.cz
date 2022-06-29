<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UredniDeskaController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/uredni-deska', name: 'uredni_deska')]
    #[Route('/iframe/obecni-urad/uredni-deska', name: 'iframe_uredni_deska')]
    public function __invoke(Request $request): Response
    {
        $templateName = 'uredni_deska.html.twig';
        if ($request->attributes->get('_route') === 'iframe_uredni_deska') {
            $templateName = 'iframe_uredni_deska.html.twig';
        }

        return $this->render($templateName, [
            'uredni_desky' => $this->contentProvider->getUredniDeskyData(shouldHideIfExpired: true),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
