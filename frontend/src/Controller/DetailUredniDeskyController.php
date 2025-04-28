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

        $displayPublishDate = true;
        $displayImage = null;

        if ($slug === 'rekonstrukce-hygienickeho-zazemi-hyg-smycka-a-zachody-a-elektroinstalace-v-denni-mistnosti-vc-podhledu-v-pozarni-zbrojnici-sdh-celadna-p-c-st-646-c-p-345-k-u-celadna-739-12-celadna-2') {
            $displayPublishDate = false;
            $displayImage = 'projekt-rekonstrukce-hygienickeho-zazemi.png';
        }

        if ($slug === 'virtualni-realita-a-robot-moji-novi-kamaradi') {
            $displayPublishDate = false;
            $displayImage = 'virtualni-realita-a-robot.jpg';
        }

        try {
            return $this->render($templateName, [
                'uredni_deska' => $this->contentProvider->getUredniDeskaData($slug),
                'footer' => $this->contentProvider->getFooterData(),
                'display_publish_date' => $displayPublishDate,
                'display_image' => $displayImage,
            ]);
        } catch (ClientException) {
            throw $this->createNotFoundException();
        }
    }
}
