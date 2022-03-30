<?php

declare(strict_types=1);

namespace Celadna\Website\Content;

use Celadna\Website\Content\Data\FooterData;

interface Content
{
    /**
     * @return array<FooterData>
     */
    public function getFooterData(): array;
}
