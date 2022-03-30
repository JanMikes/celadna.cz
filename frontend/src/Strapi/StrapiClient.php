<?php

declare(strict_types=1);

namespace Celadna\Website\Strapi;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class StrapiClient
{
    public function __construct(
        private HttpClientInterface $strapiClient,
    ) {}


    /**
     * @return mixed
     */
    public function getSingleResource(
        string $resourceName,
        array|null $populate = null,
        array|null $fields = null
    ): array
    {
        $response = $this->strapiClient->request('GET', '/api/' . $resourceName, [
            'query' => [
                'populate' => $populate ? : '*',
                'fields' => $fields ? : '*',
            ]
        ]);

        return $response->toArray();
    }
}
