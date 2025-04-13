<?php

namespace App\Service;

use App\Search\Search;
use Elastic\Elasticsearch\Client;
use Psr\Http\Message\ResponseInterface;

class SearchService
{
    private Client $client;

    public function __construct(Search $search)
    {
        $this->client = $search->getClient();
    }

    public function createIndice(
        string $index,
        array $body
    ): ResponseInterface {
        return  $this->client->indices()->create([
            'index' => $index,
            'body' => $body,
        ]);
    }

    public function createDocument(
        string $index,
        string $id,
        array $body
    ): ResponseInterface {
        return $this->client->index([
            'index' => $index,
            'id'    => $id,
            'body'  => $body
        ]);
    }

    public function searchDocuments(
        string $index,
        array $body
    ): ResponseInterface {
        return $this->client->search([
            'index' => $index,
            'body'  => $body
        ]);;
    }
}
