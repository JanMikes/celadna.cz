<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

use DateTimeImmutable;

final class DokumentPlanuData
{
    use CanCreateManyFromStrapiResponse;


    public function __construct(
        public readonly null|string $Nazev,
        public readonly null|DateTimeImmutable $Datum_nahrani,
        public readonly null|string $Soubor,
    ) {}


    public static function createFromStrapiResponse(array $data, ?int $id = null): self
    {
        return new self(
            $data['Nazev'],
            $data['Datum_nahrani'] ? DateTimeImmutable::createFromFormat('Y-m-d', $data['Datum_nahrani']) : null,
            $data['Soubor']['data']['attributes']['url'] ?? null,
        );
    }
}
