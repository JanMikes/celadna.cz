<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DetailUredniDeskyController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/obecni-urad/uredni-deska/dokument/{slug}', name: 'detail_uredni_desky')]
    public function __invoke(string $slug): Response
    {
        try {
            return $this->render('detail_uredni_desky.html.twig', [
                'uredni_deska' => $this->contentProvider->getUredniDeskaData($slug),
                'footer' => $this->contentProvider->getFooterData(),
            ]);
        } catch (ClientException) {
            throw $this->createNotFoundException();
        }
    }
}
