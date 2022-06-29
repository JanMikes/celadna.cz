<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Celadna\Website\Content\Data\KategorieUredniDesky;
use Celadna\Website\Content\Exception\InvalidKategorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UredniDeskaKategorieFilterController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/uredni-deska/kategorie/{kategorie}', name: 'uredni_deska_kategorie_filter')]
    #[Route('/iframe/obecni-urad/uredni-deska/kategorie/{kategorie}', name: 'iframe_uredni_deska_kategorie_filter')]
    public function __invoke(string $kategorie, Request $request): Response
    {
        $templateName = 'uredni_deska.html.twig';
        if ($request->attributes->get('_route') === 'iframe_uredni_deska_kategorie_filter') {
            $templateName = 'iframe_uredni_deska.html.twig';
        }

        try {
            $kategorieUredniDesky = KategorieUredniDesky::fromSlug($kategorie);

            return $this->render($templateName, [
                'uredni_desky' => $this->contentProvider->getUredniDeskyDataFilteredByKategorie($kategorie),
                'kategorie_uredni_desky' => $kategorieUredniDesky,
                'footer' => $this->contentProvider->getFooterData(),
            ]);
        } catch (InvalidKategorie) {
            throw $this->createNotFoundException();
        }
    }
}
