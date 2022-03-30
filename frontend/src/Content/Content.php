<?php

declare(strict_types=1);

namespace Celadna\Website\Content;

use Celadna\Website\Content\Data\FooterData;
use Celadna\Website\Content\Data\RestauraceData;

interface Content
{
    /**
     * @return array<FooterData>
     */
    public function getFooterData(): array;

    public function getRestauraceData(): RestauraceData;
}
