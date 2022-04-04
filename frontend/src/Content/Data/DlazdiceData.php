<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class DlazdiceData
{
    use CanCreateManyFromStrapiResponse;


    public function __construct(
        public readonly string|null $Ikona,
        public readonly string $Nadpis_dlazdice,
        public readonly string $Odkaz,
    )
    {
    }

    public static function createFromStrapiResponse(array $data, int|null $id = null): self
    {
        return new self(
            $data['Ikona']['data']['attributes']['url'] ?? null,
            $data['Nadpis_dlazdice'],
            $data['Odkaz'],
        );
    }
}
