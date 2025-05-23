<?php

namespace App\Service;

use App\Manager\Search;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Psr\Http\Message\ResponseInterface;

class DocumentService
{

    public function __construct(private Search $search)
    {
    }

    public function searchDocument(
        string $indice,
        array $body
    ): ResponseInterface {
        return $this->search->getClient()->search([
            'index' => $indice,
            'body' => $body
        ]);
    }

    public function createDocument(
        string $indice,
        int $id,
        array $body
    ): ResponseInterface {
        try {
            return $this->search->getClient()->index([
                'index' => $indice,
                'id' => $id,
                'body' => $body
            ]);
        } catch (ClientResponseException $ex) {
            return $ex->getResponse();
        }
    }

}
