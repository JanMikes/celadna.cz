<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AktualityTagFilterController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}

    #[Route('/aktuality/kategorie/{tag}', name: 'aktuality_tag_filter')]
    #[Route('/iframe/aktuality/kategorie/{tag}', name: 'iframe_aktuality_tag_filter')]
    public function __invoke(string $tag, Request $request): Response
    {
        $templateName = 'aktuality.html.twig';
        if ($request->attributes->get('_route') === 'iframe_aktuality_tag_filter') {
            $templateName = 'iframe_aktuality.html.twig';
        }

        return $this->render($templateName, [
            'tagy' => $this->contentProvider->getTagy(),
            'active_tag' => $tag,
            'aktuality' => $this->contentProvider->getAktualityData(tag: $tag),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
