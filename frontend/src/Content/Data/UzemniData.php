<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class UzemniData
{
    public function __construct(
        public readonly string $Nadpis,

        /**
         * @var array<UredniDeskaData> $Uredni_deska
         */
        public readonly array $Uredni_deska,

        /**
         * @var array<KategoriePlanyData> $Uredni_deska
         */
        public readonly array $Kategorie,
    ) {}
}
