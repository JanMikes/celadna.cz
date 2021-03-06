<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class ImageData
{
    use CanCreateManyFromStrapiResponse;

    public function __construct(
        public readonly string $name,
        public readonly string $caption,
        public readonly string $url,
        public readonly float $size,
        public readonly string $ext,
    )
    {
    }


    public static function createFromStrapiResponse(array $data, int|null $id = null): self
    {
        return new self(
            $data['name'],
            $data['caption'],
            $data['url'],
            (int) $data['size'],
            trim($data['ext'], '.'),
        );
    }
}
