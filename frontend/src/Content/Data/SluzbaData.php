<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class SluzbaData
{
    public function __construct(
        public readonly string $Nadpis,
        public readonly null|string $Telefon,
        public readonly string $Obsah,
    ) {}


    public static function createFromStrapiResponse(array $data): self
    {
        return new self($data['Nadpis'], $data['Telefon'], $data['Obsah']);
    }


    /**
     * @return array<self>
     */
    public static function createManyFromStrapiResponse(array $data): array
    {
        $objects = [];

        foreach ($data as $singleObjectData) {
            $objects[] = self::createFromStrapiResponse($singleObjectData);
        }

        return $objects;
    }
}
