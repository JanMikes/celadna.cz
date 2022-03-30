<?php

declare(strict_types=1);

namespace Celadna\Website\Content;

use Celadna\Website\Content\Data\BannerSTextemData;
use Celadna\Website\Content\Data\BannerSTlacitkamaData;
use Celadna\Website\Content\Data\FooterData;
use Celadna\Website\Content\Data\GrafickyPasData;
use Celadna\Website\Content\Data\KartaObjektuData;
use Celadna\Website\Content\Data\LetajiciObrazekData;
use Celadna\Website\Content\Data\RestauraceData;
use Celadna\Website\Content\Data\SluzbaData;
use Celadna\Website\Content\Data\SluzbyData;
use Celadna\Website\Content\Data\TlacitkoData;
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

    /**
     * @return array<GrafickyPasData>
     */
    public function getAktivityData(): array
    {
        return $this->getGrafickePasy('obec-aktivity');
    }


    /**
     * @return array<GrafickyPasData>
     */
    public function getOrganizaceData(): array
    {
        return $this->getGrafickePasy('obec-organizace');
    }


    public function getSluzbyData(): SluzbyData
    {
        $strapiResponse = $this->strapiClient->getSingleResource('obec-sluzby', [
            'Banner.Obrazek',
            'Banner.Tlacitka',
            'Sluzby'
        ]);

        return new SluzbyData(
            new BannerSTlacitkamaData(
                $strapiResponse['data']['attributes']['Banner']['Nadpis'],
                $strapiResponse['data']['attributes']['Banner']['Obrazek']['data']['attributes']['url'],
                TlacitkoData::createManyFromStrapiResponse($strapiResponse['data']['attributes']['Banner']['Tlacitka']),
            ),
            SluzbaData::createManyFromStrapiResponse($strapiResponse['data']['attributes']['Sluzby']),
        );
    }


    /**
     * @return array<GrafickyPasData>
     */
    private function getGrafickePasy(string $resourceName): array
    {
        $strapiResponse = $this->strapiClient->getSingleResource($resourceName, [
            'Graficke_pasy.Tlacitko',
            'Graficke_pasy.Obrazek',
            'Graficke_pasy.Letajici_obrazky.Obrazek',
        ]);

        $grafickePasy = [];

        foreach ($strapiResponse['data']['attributes']['Graficke_pasy'] as $grafickyPasData) {
            $letajiciObrazky = [];

            foreach ($grafickyPasData['Letajici_obrazky'] as $letajiciObrazek) {
                $letajiciObrazky[] = new LetajiciObrazekData(
                    $letajiciObrazek['Left'],
                    $letajiciObrazek['Right'],
                    $letajiciObrazek['Top'],
                    $letajiciObrazek['Bottom'],
                    $letajiciObrazek['Obrazek']['data']['attributes']['url'],
                );
            }

            $grafickePasy[] = new GrafickyPasData(
                $grafickyPasData['Umisteni'],
                $grafickyPasData['Barva_gradientu_1'],
                $grafickyPasData['Barva_gradientu_2'],
                $grafickyPasData['Nadpis'],
                $grafickyPasData['Obsah'],
                $grafickyPasData['Obrazek']['data']['attributes']['url'],
                TlacitkoData::createFromStrapiResponse($grafickyPasData['Tlacitko']),
                $letajiciObrazky,
            );
        }

        return $grafickePasy;
    }
}
