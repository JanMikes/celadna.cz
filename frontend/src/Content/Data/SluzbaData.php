<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class SluzbaData
{
    use CanCreateManyFromStrapiResponse;


    public function __construct(
        public readonly string $Nadpis,
        public readonly null|string $Telefon,
        public readonly string $Obsah,
    ) {}


    public static function createFromStrapiResponse(array $data, int|null $id = null): self
    {
        return new self($data['Nadpis'], $data['Telefon'], $data['Obsah']);
    }
}
