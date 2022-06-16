<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class IframeAktualityTagFilterController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}

    #[Route('/iframe/aktuality/kategorie/{tag}', name: 'iframe_aktuality_tag_filter')]
    public function __invoke(string $tag): Response
    {
        return $this->render('iframe_aktuality.html.twig', [
            'tagy' => $this->contentProvider->getTagy(),
            'active_tag' => $tag,
            'aktuality' => $this->contentProvider->getAktualityData(tag: $tag),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
