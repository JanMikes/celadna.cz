<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

use DateTimeImmutable;

final class KategoriePlanyData
{
    public function __construct(
        public readonly null|string $Nazev,
        public readonly null|DateTimeImmutable $Datum_vyveseni,
        public readonly null|string $Obsah,

        /**
         * @var array<DokumentPlanuData> $Dokumenty
         */
        public readonly array $Dokumenty,
    ) {}
}
