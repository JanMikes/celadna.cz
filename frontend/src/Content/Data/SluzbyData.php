<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class SluzbyData
{
    public function __construct(
        public readonly BannerSTlacitkamaData $BannerSTlacitkama,

        /**
         * @var array<SluzbaData> $Sluzby
         */
        public readonly array $Sluzby,
    ) {}
}
