<?php

declare(strict_types=1);

namespace Celadna\Website\Strapi;

use Celadna\Website\Content\Content;
use Celadna\Website\Content\Data\AktualitaData;
use Celadna\Website\Content\Data\BannerSTextemData;
use Celadna\Website\Content\Data\BannerSTlacitkamaData;
use Celadna\Website\Content\Data\FooterData;
use Celadna\Website\Content\Data\GdprData;
use Celadna\Website\Content\Data\DokumentyData;
use Celadna\Website\Content\Data\GrafickyPasData;
use Celadna\Website\Content\Data\KartaObjektuData;
use Celadna\Website\Content\Data\KontaktyData;
use Celadna\Website\Content\Data\PristupnostData;
use Celadna\Website\Content\Data\RestauraceData;
use Celadna\Website\Content\Data\SamospravaData;
use Celadna\Website\Content\Data\SekceSDlazdicemaData;
use Celadna\Website\Content\Data\SluzbaData;
use Celadna\Website\Content\Data\SluzbyData;
use Celadna\Website\Content\Data\StrukturaUraduData;
use Celadna\Website\Content\Data\TlacitkoData;
use Celadna\Website\Content\Data\UbytovaniData;
use Celadna\Website\Content\Data\UradData;
use Celadna\Website\Content\Data\UredniDeskaData;
use Symfony\Component\HttpClient\Exception\ClientException;

final class StrapiContent implements Content
{
    public function __construct(
        private StrapiApiClient $strapiClient,
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
                $footerData['Obrazek']['data']['attributes']['url'] ?? null
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
        $strapiResponse = $this->strapiClient->getApiResource('aktualities', [
            'Obrazek',
            'Galerie',
            'Zverejnil.Fotka',
            'Tagy',
        ],
        filters: [
            'Zobrazovat' => ['$eq' => true],
        ]);

        return AktualitaData::createManyFromStrapiResponse($strapiResponse['data']);
    }


    /**
     * @return array<GrafickyPasData>
     */
    private function getGrafickePasy(string $resourceName): array
    {
        try {
            $strapiResponse = $this->strapiClient->getApiResource($resourceName, [
                'Graficke_pasy.Tlacitko',
                'Graficke_pasy.Obrazek',
                'Graficke_pasy.Letajici_obrazky.Obrazek',
            ]);
        } catch (ClientException $clientException) {
            if ($clientException->getCode() === 404) {
                return [];
            }

            throw $clientException;
        }

        return GrafickyPasData::createManyFromStrapiResponse($strapiResponse['data']['attributes']['Graficke_pasy']);
    }

    public function getAktualitaData(int $id): AktualitaData
    {
        $strapiResponse = $this->strapiClient->getApiResource('aktualities/' . $id, [
            'Obrazek',
            'Galerie',
            'Zverejnil.Fotka',
            'Tagy',
        ], filters: [
            'Zobrazovat' => ['$eq' => true],
        ]);

        return AktualitaData::createFromStrapiResponse($strapiResponse['data']['attributes']);
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
        $uredniDeska = [];

        if ($strapiResponse['data']['attributes']['Zobrazovat_komponentu_uredni_desky'] === true) {
            $field = $this->resourceNameToUredniDeskaCategoryField($resourceName);
            $uredniDeska = $this->getUredniDeskyData($field);
        }

        return new DokumentyData(
            $strapiResponse['data']['attributes']['Nadpis'],
            $strapiResponse['data']['attributes']['Obsah'],
            $uredniDeska,
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


    public function getDokumentyVerejnopravniSmlouvyData(): DokumentyData
    {
        return $this->getGenericDokumentyData('urad-dokumenty-verejnopravni-smlouvy');
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


    public function getDokumentyVyrocniZpravaData(): DokumentyData
    {
        return $this->getGenericDokumentyData('urad-dokumenty-vyrocni-zprava');
    }


    public function getDokumentyZivotniSituaceData(): DokumentyData
    {
        return $this->getGenericDokumentyData('urad-dokumenty-zivotni-situace');
    }


    public function getDokumentyPovinneInformaceData(): DokumentyData
    {
        return $this->getGenericDokumentyData('urad-povinne-zverejnovane-informace');
    }


    /**
     * @return array<SamospravaData>
     */
    public function getSamospravaData(): array
    {
        $strapiResponse = $this->strapiClient->getApiResource('urad-samosprava', [
            'Kategorie_samospravy.Lide.Clovek.Fotka'
        ]);

        // TODO: napojeni na uredni desku

        return SamospravaData::createManyFromStrapiResponse($strapiResponse['data']['attributes']['Kategorie_samospravy']);
    }


    public function getKontaktyData(): KontaktyData
    {
        $strapiResponse = $this->strapiClient->getApiResource('urad-kontakty',[
            'Banner.Obrazek',
            'Vedeni_obce.Clovek.Fotka',
        ]);

        return KontaktyData::createFromStrapiResponse($strapiResponse['data']['attributes']);
    }


    public function getStrukturaUraduData(): StrukturaUraduData
    {
        $strapiResponse = $this->strapiClient->getApiResource('urad-struktura-uradu', [
            'Banner.Obrazek',
            'Struktura_uradu.Clovek.Fotka',
            'Struktura_stavebniho_uradu.Clovek.Fotka',
        ]);

        return StrukturaUraduData::createFromStrapiResponse($strapiResponse['data']['attributes']);
    }


    public function getUradData(): UradData
    {
        $strapiResponse = $this->strapiClient->getApiResource('urad', [
            'Banner.Obrazek',
            'Sekce_s_dlazdicema.Dlazdice.Ikona',
        ]);

        return new UradData(
            BannerSTextemData::createFromStrapiResponse($strapiResponse['data']['attributes']['Banner']),
            SekceSDlazdicemaData::createFromStrapiResponse($strapiResponse['data']['attributes']['Sekce_s_dlazdicema']),
        );
    }


    /**
     * @return array<UredniDeskaData>
     */
    public function getUredniDeskyData(string|null $categoryField = null): array
    {
        $filters = ['Zobrazovat' => ['$eq' => true]];

        if ($categoryField) {
            $filters[$categoryField] = ['$eq' => true];
        }

        $strapiResponse = $this->strapiClient->getApiResource('uredni-deskas', [
            'Soubory',
            'Zodpovedna_osoba.Fotka',
        ], filters: $filters);

        return UredniDeskaData::createManyFromStrapiResponse($strapiResponse);
    }

    public function getUredniDeskaData(int $id): UredniDeskaData
    {
        $strapiResponse = $this->strapiClient->getApiResource('uredni-deskas/' . $id, [
            'Soubory',
            'Zodpovedna_osoba.Fotka',
        ], filters: [
            'Zobrazovat' => ['$eq' => true],
        ]);

        return UredniDeskaData::createFromStrapiResponse($strapiResponse['data']['attributes']);
    }


    private function resourceNameToUredniDeskaCategoryField(string $resourceName): string
    {
        return match ($resourceName) {
            'urad-dokumenty-formulare' => 'Zobrazit_v_formulare',
            'urad-dokumenty-navody' => 'Zobrazit_v_navody',
            'urad-dokumenty-odpady' => 'Zobrazit_v_odpady',
            'urad-dokumenty-rozpocty' => 'Zobrazit_v_rozpocty',
            'urad-dokumenty-strategicke-dokumenty' => 'Zobrazit_v_strategicke_dokumenty',
            'urad-dokumenty-uzemni-plan' => 'Zobrazit_v_uzemni_plan',
            'urad-dokumenty-uzemni-studie' => 'Zobrazit_v_uzemni_studie',
            'urad-dokumenty-vyhlasky' => 'Zobrazit_v_vyhlasky',
            'urad-dokumenty-vyrocni-zprava' => 'Zobrazit_v_vyrocni_zpravy',
            'urad-dokumenty-zivotni-situace' => 'Zobrazit_v_zivotni_situace',
            'urad-povinne-zverejnovane-informace' => 'Zobrazit_v_poskytnute_informace',
            'urad-dokumenty-verejnopravni-smlouvy' => 'Zobrazit_v_verejnopravni_smlouvy',
            default => throw new \LogicException('Resource not matched: ' . $resourceName),
        };
    }
}
