<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class RestauraceData
{
    public function __construct(
        public readonly BannerSTextemData $BannerSTextem,
        /**
         * @var array<KartaObjektuData> $Restaurace
         */
        public readonly array $Restaurace,
    ) {}
}
