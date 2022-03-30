<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class GrafickyPasData
{
    public function __construct(
        public string $Umisteni,
        public string $Barva_gradientu_1,
        public string $Barva_gradientu_2,
        public string $Nadpis,
        public string $Obsah,
        public string $Obrazek,
        public TlacitkoData $Tlacitko,
        /**
         * @var array<LetajiciObrazekData> $Letajici_obrazky
         */
        public array $Letajici_obrazky,
    ) {}
}
