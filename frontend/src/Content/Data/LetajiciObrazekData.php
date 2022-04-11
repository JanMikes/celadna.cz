<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class LetajiciObrazekData
{
    use CanCreateManyFromStrapiResponse;


    public function __construct(
        public readonly int|null $Left,
        public readonly int|null $Right,
        public readonly int|null $Top,
        public readonly int|null $Bottom,
        public readonly string $Obrazek,
        public readonly float $Scale,
    ) {}


    public static function createFromStrapiResponse(array $data, int|null $id = null): self
    {
        return new self(
            $data['Left'],
            $data['Right'],
            $data['Top'],
            $data['Bottom'],
            $data['Obrazek']['data']['attributes']['url'],
            ($data['Velikost_procent'] ?? 100) / 100,
        );
    }
}
