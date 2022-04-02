<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class TlacitkoData
{
    use CanCreateManyFromStrapiResponse;


    public function __construct(
        public string $Text,
        public string $Odkaz,
    ) {}


    public static function createFromStrapiResponse(array $data, int|null $id = null): self
    {
        return new self($data['Text'], $data['Odkaz']);
    }
}
