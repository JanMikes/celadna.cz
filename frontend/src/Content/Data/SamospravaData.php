<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class SamospravaData
{
    use CanCreateManyFromStrapiResponse;


    public function __construct(
        public readonly string $Nadpis,
        public readonly string|null $Obsah,
        public readonly string $Kategorie_uredni_desky,

        /**
         * @var array<ClovekData> $Lide
         */
        public readonly array $Lide,
    ) {
    }


    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['Nadpis'],
            $data['Obsah'],
            $data['Kategorie_uredni_desky'],
            ClovekData::createManyFromStrapiResponse($data['Lide']),
        );
    }
}
