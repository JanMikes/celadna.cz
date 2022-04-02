<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class AktualitaData
{
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public readonly int|null $id,
        public string $Nadpis,
        public \DateTimeImmutable $DatumZverejneni,
        public string $Obrazek,
        public string|null $Video_youtube,

        /**
         * @var string[] $Galerie
         */
        public array $Galerie,

        public ClovekData $Zverejnil,

        /**
         * @var string[] $Tagy,
         */
        public array $Tagy,

        public readonly string $Popis,
    ) {}


    public static function createFromStrapiResponse(array $data, int|null $id = null): self
    {
        return new self(
            $id,
            $data['Nadpis'],
            \DateTimeImmutable::createFromFormat('Y-m-d', $data['Datum_zverejneni']),
            $data['Obrazek']['data']['attributes']['url'],
            $data['Video_youtube'],
            array_map(fn(array $galerieData) => $galerieData['attributes']['url'], $data['Galerie']['data']),
            ClovekData::createFromStrapiResponse($data['Zverejnil']['data']['attributes']),
            array_map(fn(array $tagyData) => $tagyData['attributes']['Tag'], $data['Tagy']['data']),
            $data['Popis'],
        );
    }
}
