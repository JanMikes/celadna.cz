<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DetailUredniDeskyController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/uredni-deska/dokument/{slug}', name: 'detail_uredni_desky')]
    #[Route('/iframe/obecni-urad/uredni-deska/dokument/{slug}', name: 'iframe_detail_uredni_desky')]
    public function __invoke(string $slug, Request $request): Response
    {
        $templateName = 'detail_uredni_desky.html.twig';
        if ($request->attributes->get('_route') === 'iframe_detail_uredni_desky') {
            $templateName = 'iframe_detail_uredni_desky.html.twig';
        }

        try {
            return $this->render($templateName, [
                'uredni_deska' => $this->contentProvider->getUredniDeskaData($slug),
                'footer' => $this->contentProvider->getFooterData(),
            ]);
        } catch (ClientException) {
            throw $this->createNotFoundException();
        }
    }
}
