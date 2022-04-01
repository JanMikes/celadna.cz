<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class LetajiciObrazekData
{
    use CanCreateManyFromStrapiResponse;


    public function __construct(
        public int $Left,
        public int $Right,
        public int $Top,
        public int $Bottom,
        public string $Obrazek,
    ) {}


    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['Left'],
            $data['Right'],
            $data['Top'],
            $data['Bottom'],
            $data['Obrazek']['data']['attributes']['url'],
        );
    }
}
