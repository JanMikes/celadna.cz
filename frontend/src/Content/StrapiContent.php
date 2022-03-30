<?php

declare(strict_types=1);

namespace Celadna\Website\Content;

use Celadna\Website\Content\Data\BannerSTextemData;
use Celadna\Website\Content\Data\FooterData;
use Celadna\Website\Content\Data\KartaObjektuData;
use Celadna\Website\Content\Data\RestauraceData;
use Celadna\Website\Strapi\StrapiClient;

final class StrapiContent implements Content
{
    public function __construct(
        private StrapiClient $strapiClient,
    ) {}


    /**
     * @return array<FooterData>
     */
    public function getFooterData(): array
    {
        $strapiResponse = $this->strapiClient->getSingleResource('footer', [
            'Reklama_607x433.Obrazek',
        ]);

        $result = [];
        foreach ($strapiResponse['data']['attributes']['Reklama_607x433'] as $footerData) {
            $result[] = new FooterData(
                $footerData['Odkaz'],
                $footerData['Obrazek']['data']['attributes']['url']
            );
        }

        return $result;
    }


    public function getRestauraceData(): RestauraceData
    {
        $strapiResponse = $this->strapiClient->getSingleResource('obec-restaurace', [
            'Banner.Obrazek',
            'Restaurace.Obrazek',
        ]);

        $banner = new BannerSTextemData(
            $strapiResponse['data']['attributes']['Banner']['Nadpis'],
            $strapiResponse['data']['attributes']['Banner']['Obrazek']['data']['attributes']['url'],
            $strapiResponse['data']['attributes']['Banner']['Text_pod_nadpisem'],
        );

        $objekty = [];
        foreach ($strapiResponse['data']['attributes']['Restaurace'] as $objektData) {
            $objekty[] = new KartaObjektuData(
                $objektData['Obrazek']['data']['attributes']['url'],
                $objektData['Nazev'],
                $objektData['Telefon'],
                $objektData['Email'],
                $objektData['Odkaz_web'],
                $objektData['Odkaz_mapa'],
                $objektData['Adresa'],
            );
        }

        return new RestauraceData($banner, $objekty);
    }
}
