<?php

declare(strict_types=1);

namespace Celadna\Website\Content;

use Celadna\Website\Content\Data\AktualitaData;
use Celadna\Website\Content\Data\BannerSTextemData;
use Celadna\Website\Content\Data\BannerSTlacitkamaData;
use Celadna\Website\Content\Data\FooterData;
use Celadna\Website\Content\Data\GdprData;
use Celadna\Website\Content\Data\DokumentyData;
use Celadna\Website\Content\Data\GrafickyPasData;
use Celadna\Website\Content\Data\KartaObjektuData;
use Celadna\Website\Content\Data\LetajiciObrazekData;
use Celadna\Website\Content\Data\PristupnostData;
use Celadna\Website\Content\Data\RestauraceData;
use Celadna\Website\Content\Data\SluzbaData;
use Celadna\Website\Content\Data\SluzbyData;
use Celadna\Website\Content\Data\TlacitkoData;
use Celadna\Website\Content\Data\UbytovaniData;
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
        $strapiResponse = $this->strapiClient->getApiResource('footer', [
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
        $strapiResponse = $this->strapiClient->getApiResource('obec-restaurace', [
            'Banner.Obrazek',
            'Restaurace.Obrazek',
        ]);

        return new RestauraceData(
            BannerSTextemData::createFromStrapiResponse($strapiResponse['data']['attributes']['Banner']),
            KartaObjektuData::createManyFromStrapiResponse($strapiResponse['data']['attributes']['Restaurace']),
        );
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
        $strapiResponse = $this->strapiClient->getApiResource('obec-sluzby', [
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
     * @return array<AktualitaData>
     */
    public function getAktualityData(): array
    {
        $strapiResponse = $this->strapiClient->getApiResource('aktualities',
            filters: [
                'Zobrazovat' => ['$eq' => true],
            ],
        );

        return AktualitaData::createManyFromStrapiReseponse($strapiResponse['data']);
    }


    /**
     * @return array<GrafickyPasData>
     */
    private function getGrafickePasy(string $resourceName): array
    {
        $strapiResponse = $this->strapiClient->getApiResource($resourceName, [
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
                $grafickyPasData['Tlacitko'] ? TlacitkoData::createFromStrapiResponse($grafickyPasData['Tlacitko']) : null,
                $letajiciObrazky,
            );
        }

        return $grafickePasy;
    }

    public function getAktualitaData(int $id): AktualitaData
    {
        $strapiResponse = $this->strapiClient->getApiResource('aktualities/' . $id,
            filters: [
                'Zobrazovat' => ['$eq' => true],
            ],
        );

        return AktualitaData::createFromStrapiResponse($strapiResponse['data']);
    }


    public function getGdprData(): GdprData
    {
        $strapiResponse = $this->strapiClient->getApiResource('gdpr');

        return new GdprData(
            $strapiResponse['data']['attributes']['Nadpis'],
            $strapiResponse['data']['attributes']['Obsah'],
        );
    }


    public function getUbytovaniData(): UbytovaniData
    {
        $strapiResponse = $this->strapiClient->getApiResource('obec-ubytovani', [
            'Banner.Obrazek',
            'Ubytovani.Obrazek'
        ]);

        return new UbytovaniData(
            BannerSTextemData::createFromStrapiResponse($strapiResponse['data']['attributes']['Banner']),
            KartaObjektuData::createManyFromStrapiResponse($strapiResponse['data']['attributes']['Ubytovani']),
        );
    }


    public function getVyletyData(): array
    {
        return $this->getGrafickePasy('obec-vylety');
    }


    public function getPristupnostData(): PristupnostData
    {
        $strapiResponse = $this->strapiClient->getApiResource('prohlaseni-o-pristupnosti');

        return new PristupnostData(
            $strapiResponse['data']['attributes']['Nadpis'],
            $strapiResponse['data']['attributes']['Obsah'],
        );
    }


    private function getGenericDokumentyData(string $resourceName): DokumentyData
    {
        $strapiResponse = $this->strapiClient->getApiResource($resourceName);

        if ($strapiResponse['data']['attributes']['Zobrazovat_komponentu_uredni_desky'] === true) {
            // TODO !!!
        }

        return new DokumentyData(
            $strapiResponse['data']['attributes']['Nadpis'],
            $strapiResponse['data']['attributes']['Obsah'],
        );
    }


    public function getDokumentyFormulareData(): DokumentyData
    {
        return $this->getGenericDokumentyData('urad-dokumenty-formulare');
    }


    public function getDokumentyNavodyData(): DokumentyData
    {
        return $this->getGenericDokumentyData('urad-dokumenty-navody');
    }


    public function getDokumentyOdpadyData(): DokumentyData
    {
        return $this->getGenericDokumentyData('urad-dokumenty-odpady');
    }


    public function getDokumentyRozpoctyData(): DokumentyData
    {
        return $this->getGenericDokumentyData('urad-dokumenty-rozpocty');
    }


    public function getDokumentyStrategickeDokumentyData(): DokumentyData
    {
        return $this->getGenericDokumentyData('urad-dokumenty-strategicke-dokumenty');
    }


    public function getDokumentyUzemniPlanData(): DokumentyData
    {
        return $this->getGenericDokumentyData('urad-dokumenty-uzemni-plan');
    }


    public function getDokumentyUzemniStudieData(): DokumentyData
    {
        return $this->getGenericDokumentyData('urad-dokumenty-uzemni-studie');
    }


    public function getDokumentyVyhlaskyData(): DokumentyData
    {
        return $this->getGenericDokumentyData('urad-dokumenty-vyhlasky');
    }
}
