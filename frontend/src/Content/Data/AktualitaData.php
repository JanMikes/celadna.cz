<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

use DateTimeImmutable;

final class AktualitaData
{
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public readonly int|null $id,
        public readonly string $Nadpis,
        public readonly DateTimeImmutable $DatumZverejneni,
        public readonly string $Obrazek,
        public readonly string|null $Video_youtube,

        /**
         * @var string[] $Galerie
         */
        public readonly array $Galerie,

        public readonly ClovekData|null $Zverejnil,

        /**
         * @var string[] $Tagy,
         */
        public readonly array $Tagy,

        public readonly string $Popis,
    ) {}


    public static function createFromStrapiResponse(array $data, int|null $id = null): self
    {
        return new self(
            $id,
            $data['Nadpis'],
            DateTimeImmutable::createFromFormat('Y-m-d', $data['Datum_zverejneni']),
            $data['Obrazek']['data']['attributes']['url'],
            $data['Video_youtube'],
            $data['Galerie']['data'] ? array_map(fn(array $galerieData) => $galerieData['attributes']['url'], $data['Galerie']['data']) : [],
            $data['Zverejnil']['data'] ? ClovekData::createFromStrapiResponse($data['Zverejnil']['data']['attributes']) : null,
            array_map(fn(array $tagyData) => $tagyData['attributes']['Tag'], $data['Tagy']['data']),
            $data['Popis'],
        );
    }
}
