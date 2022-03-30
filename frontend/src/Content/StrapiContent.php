<?php

declare(strict_types=1);

namespace Celadna\Website\Content;

use Celadna\Website\Content\Data\FooterData;
use Celadna\Website\Strapi\StrapiClient;

final class StrapiContent implements Content
{
    public function __construct(
        private StrapiClient $strapiClient,
    ) {}


    /**
     * @return array<FooterData>
     */
    public function getFooterData(): array
    {
        $strapiResponse = $this->strapiClient->getSingleResource('footer', [
            'Reklama_607x433.Obrazek',
        ]);

        return [];
    }
}
