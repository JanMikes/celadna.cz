<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class GrafickyPasData
{
    use CanCreateManyFromStrapiResponse;


    public function __construct(
        public string $Umisteni,
        public string $Barva_gradientu_1,
        public string $Barva_gradientu_2,
        public string $Nadpis,
        public string $Obsah,
        public string $Obrazek,
        public TlacitkoData|null $Tlacitko,
        /**
         * @var array<LetajiciObrazekData> $Letajici_obrazky
         */
        public array $Letajici_obrazky,
    ) {}


    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['Umisteni'],
            $data['Barva_gradientu_1'],
            $data['Barva_gradientu_2'],
            $data['Nadpis'],
            $data['Obsah'],
            $data['Obrazek']['data']['attributes']['url'],
            $data['Tlacitko'] ? TlacitkoData::createFromStrapiResponse($data['Tlacitko']) : null,
            LetajiciObrazekData::createManyFromStrapiResponse($data['Letajici_obrazky']),
        );
    }
}
