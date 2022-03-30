<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class TlacitkoData
{
    public function __construct(
        public string $Text,
        public string $Odkaz,
    )
    {
    }
}
