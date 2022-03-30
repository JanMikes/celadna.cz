<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class TlacitkoData
{
    public function __construct(
        public string $Text,
        public string $Odkaz,
    ) {}


    public static function createFromStrapiResponse(array $data): self
    {
        return new self($data['Text'], $data['Odkaz']);
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
