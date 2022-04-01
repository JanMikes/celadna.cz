<?php

declare(strict_types=1);

namespace Celadna\Website\Content;

use Celadna\Website\Content\Data\AktualitaData;
use Celadna\Website\Content\Data\FooterData;
use Celadna\Website\Content\Data\GdprData;
use Celadna\Website\Content\Data\GrafickyPasData;
use Celadna\Website\Content\Data\RestauraceData;
use Celadna\Website\Content\Data\SluzbyData;
use Celadna\Website\Content\Data\UbytovaniData;

interface Content
{
    /**
     * @return array<FooterData>
     */
    public function getFooterData(): array;

    public function getRestauraceData(): RestauraceData;

    /**
     * @return array<GrafickyPasData>
     */
    public function getAktivityData(): array;

    /**
     * @return array<GrafickyPasData>
     */
    public function getOrganizaceData(): array;

    public function getSluzbyData(): SluzbyData;

    /**
     * @return array<AktualitaData>
     */
    public function getAktualityData(): array;

    public function getAktualitaData(int $id): AktualitaData;

    public function getGdprData(): GdprData;

    public function getUbytovaniData(): UbytovaniData;

    /**
     * @return array<GrafickyPasData>
     */
    public function getVyletyData(): array;
}
