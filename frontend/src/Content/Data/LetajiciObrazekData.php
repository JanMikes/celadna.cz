<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class LetajiciObrazekData
{
    public function __construct(
        public int $Left,
        public int $Right,
        public int $Top,
        public int $Bottom,
        public string $Obrazek,
    ) {}
}
