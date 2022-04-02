<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class KontaktyData
{
    public function __construct(
        public readonly BannerSTextemData $Banner,
        public readonly string $Obsah,

        /**
         * @var array<ClovekData> $Vedeni_obce
         */
        public readonly array $Vedeni_obce,
    ) {}


    public static function createFromStrapiResponse(array $data, int|null $id = null): self
    {
        return new self(
            BannerSTextemData::createFromStrapiResponse($data['Banner']),
            $data['Obsah'],
            ClovekData::createManyFromStrapiResponse($data['Vedeni_obce'])
        );
    }
}
