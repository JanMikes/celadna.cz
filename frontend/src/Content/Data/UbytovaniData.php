<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class UbytovaniData
{
    public function __construct(
        public readonly BannerSTextemData $BannerSTextem,

        /**
         * @var array<KartaObjektuData> $Ubytovani
         */
        public readonly array $Ubytovani,
    ){}
}
