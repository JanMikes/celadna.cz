<?php

declare(strict_types=1);

namespace Celadna\Website\Controller;

use Celadna\Website\Content\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DetailAktualityController extends AbstractController
{
    public function __construct(
        private Content $contentProvider
    ) {}


    #[Route('/aktualita/{id}', name: 'detail_aktuality')]
    public function __invoke($id): Response
    {
        try {
            return $this->render('detail_aktuality.html.twig',[
                'aktualita' => $this->contentProvider->getAktualitaData((int) $id),
                'footer' => $this->contentProvider->getFooterData(),
            ]);
        } catch (ClientException) {
            throw $this->createNotFoundException();
        }
    }
}
