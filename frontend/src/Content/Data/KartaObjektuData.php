<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class KartaObjektuData
{
    public function __construct(
        public readonly string $Obrazek,
        public readonly string $Nazev,
        public readonly null|string $Telefon,
        public readonly null|string $Email,
        public readonly null|string $Odkaz_web,
        public readonly null|string $Odkaz_mapa,
        public readonly null|string $Adresa,
    ) {}
}
