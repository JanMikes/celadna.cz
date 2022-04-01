<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

trait CanCreateManyFromStrapiResponse
{
    abstract public static function createFromStrapiResponse(array $data): self;


    /**
     * @return array<self>
     */
    public static function createManyFromStrapiResponse(array $data): array
    {
        $objects = [];
        $data = $data['data'] ?? $data;

        foreach ($data as $singleObjectData) {
            $objects[] = self::createFromStrapiResponse($singleObjectData['attributes'] ?? $singleObjectData);
        }

        return $objects;
    }
}
