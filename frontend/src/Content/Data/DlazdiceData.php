<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class DlazdiceData
{
    use CanCreateManyFromStrapiResponse;


    public function __construct(
        public readonly string $Ikona,
        public readonly string $Nadpis_dlazdice,
        public readonly string $Odkaz,
    )
    {
    }

    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['Ikona']['data']['attributes']['url'],
            $data['Nadpis_dlazdice'],
            $data['Odkaz'],
        );
    }
}
