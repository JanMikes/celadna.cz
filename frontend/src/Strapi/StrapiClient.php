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
    public function getApiResource(
        string $resourceName,
        array|null $populate = null,
        array|null $fields = null,
        array|null $filters = null,
    ): array
    {
        $query = [
            'populate' => $populate ?: '*',
            'fields' => $fields ?: '*',
        ];

        if ($filters !== null) {
            $query['filters'] = $filters;
        }

        $response = $this->strapiClient->request('GET', '/api/' . $resourceName, [
            'query' => $query
        ]);

        return $response->toArray();
    }
}
