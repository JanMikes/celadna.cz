<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

use DateTimeImmutable;
use DateTimeInterface;

final class UredniDeskaData
{
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public readonly int|null $id,
        public readonly string $Nadpis,
        public readonly DateTimeInterface $Datum_zverejneni,
        public readonly DateTimeInterface|null $Datum_stazeni,

        /**
         * @var array<string> $Soubory
         */
        public readonly array $Soubory,
        public readonly string|null $Popis,
        public readonly ClovekData|null $Zodpovedna_osoba,
    )
    {
    }

    // TODO: kategorie

    public static function createFromStrapiResponse(array $data, int|null $id = null): self
    {
        return new self(
            $id,
            $data['Nadpis'],
            DateTimeImmutable::createFromFormat('Y-m-d', $data['Datum_zverejneni']),
            $data['Datum_stazeni'] ? DateTimeImmutable::createFromFormat('Y-m-d', $data['Datum_stazeni']) : null,
            $data['Soubory']['data'] ? array_map(fn(array $souborData) => $souborData['attributes']['url'], $data['Soubory']['data']) : [],
            $data['Popis'],
            $data['Zodpovedna_osoba']['data'] ? ClovekData::createFromStrapiResponse($data['Zodpovedna_osoba']['data']['attributes']) : null,
        );
    }
}
