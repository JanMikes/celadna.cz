<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class DokumentyData
{
    public function __construct(
        public readonly string|null $Nadpis,
        public readonly string|null $Obsah,
    ) {}
}
