<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class BannerSTextemData
{
    public function __construct(
        public readonly string $Nadpis,
        public readonly string $Obrazek,
        public readonly string $Text_pod_nadpisem,
    ) {}


    public static function createFromStrapiResponse(array $data): self
    {
        return new self(
            $data['Nadpis'],
            $data['Obrazek']['data']['attributes']['url'],
            $data['Text_pod_nadpisem'],
        );
    }
}
