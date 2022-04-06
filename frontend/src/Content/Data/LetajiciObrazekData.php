<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class LetajiciObrazekData
{
    use CanCreateManyFromStrapiResponse;


    public function __construct(
        public int|null $Left,
        public int|null $Right,
        public int|null $Top,
        public int|null $Bottom,
        public string $Obrazek,
    ) {}


    public static function createFromStrapiResponse(array $data, int|null $id = null): self
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
