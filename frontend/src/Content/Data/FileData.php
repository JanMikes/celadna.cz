<?php

declare(strict_types=1);

namespace Celadna\Website\Content\Data;

final class FileData
{
    public static function createFromStrapiResponse(): self
    {
        return new self();
    }
}
