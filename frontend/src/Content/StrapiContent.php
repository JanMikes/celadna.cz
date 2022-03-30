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

        $result = [];
        foreach ($strapiResponse['data']['attributes']['Reklama_607x433'] as $footerData) {
            $result[] = new FooterData(
                $footerData['Odkaz'],
                $footerData['Obrazek']['data']['attributes']['url']
            );
        }

        return $result;
    }
}
