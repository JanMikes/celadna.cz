<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

use DateTimeImmutable;

final class DokumentPlanuData
{
    public function __construct(
        public readonly null|string $Nazev,
        public readonly null|DateTimeImmutable $Datum_nahrani,
        public readonly null|string $Soubor,
    ) {}
}
