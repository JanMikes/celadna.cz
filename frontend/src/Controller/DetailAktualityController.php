<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DetailAktualityController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/aktualita/{slug}', name: 'detail_aktuality')]
    #[Route('/iframe/aktualita/{slug}', name: 'iframe_detail_aktuality')]
    public function __invoke(string $slug, Request $request): Response
    {
        $templateName = 'detail_aktuality.html.twig';
        if ($request->attributes->get('_route') === 'iframe_detail_aktuality') {
            $templateName = 'iframe_detail_aktuality.html.twig';
        }

        try {
            return $this->render($templateName,[
                'aktualita' => $this->contentProvider->getAktualitaData($slug),
                'footer' => $this->contentProvider->getFooterData(),
            ]);
        } catch (ClientException) {
            throw $this->createNotFoundException();
        }
    }
}
