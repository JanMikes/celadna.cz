<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class FooterData
{
    public function __construct(
        public readonly string $Odkaz,
        public readonly string $Obrazek,
    ) {}
}
