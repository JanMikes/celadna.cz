<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class GdprData
{
    public function __construct(
        public string $Nadpis,
        public string $Obsah,
    ) {}
}
