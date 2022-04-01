<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class AktualitaData
{
    use CanCreateManyFromStrapiResponse;

    public function __construct(
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
    ) {}


    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['attributes']['Nadpis'],
            \DateTimeImmutable::createFromFormat('Y-m-d', $data['attributes']['Datum_zverejneni']),
            $data['attributes']['Obrazek']['data']['attributes']['url'],
            $data['attributes']['Video_youtube'],
            array_map(fn(array $galerieData) => $galerieData['attributes']['url'], $data['attributes']['Galerie']['data']),
            ClovekData::createFromStrapiResponse($data['attributes']['Zverejnil']['data']['attributes']),
            array_map(fn(array $tagyData) => $tagyData['attributes']['Tag'], $data['attributes']['Tagy']['data']),
        );
    }
}
