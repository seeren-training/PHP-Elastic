<?php

namespace App\Service;

use App\Manager\Search;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Psr\Http\Message\ResponseInterface;

class IndiceService
{

    public function __construct(private Search $search){}

    public function createIndice(array $params): ResponseInterface
    {
        try {
            return $this->search
                ->getClient()
                ->indices()
                ->create($params);
        } catch (ClientResponseException $ex) {
            return $ex->getResponse();
        }
    }

}
