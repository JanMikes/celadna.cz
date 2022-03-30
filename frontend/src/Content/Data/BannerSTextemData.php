<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class BannerSTextemData
{
    public function __construct(
        public readonly string $Nadpis,
        public readonly string $Obrazek,
        public readonly string $Text_pod_nadpisem,
    )
    {
    }
}
