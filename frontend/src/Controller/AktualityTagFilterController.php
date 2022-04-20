<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AktualityTagFilterController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}

    #[Route('/aktuality/kategorie/{tag}', name: 'aktuality_tag_filter')]
    public function __invoke(string $tag): Response
    {
        return $this->render('aktuality.html.twig', [
            'tagy' => $this->contentProvider->getTagy(),
            'active_tag' => $tag,
            'aktuality' => $this->contentProvider->getAktualityData(tag: $tag),
            'footer' => $this->contentProvider->getFooterData(),
        ]);
    }
}
