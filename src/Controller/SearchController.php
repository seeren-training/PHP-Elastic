<?php

namespace App\Controller;

use App\Service\SearchService;
use Seeren\Controller\JsonController;
use Seeren\Router\Route\Route;

class SearchController extends JsonController
{

    #[Route("/search/indices", "POST")]
    public function create(SearchService $searchService)
    {
        $payload = $this->getRequest()->getParsedBody();

        $response = $searchService->createIndice(
            $payload['index'],
            $payload['body']
        );

        return $this->render(
            (string) $response->getBody(),
            $response->getStatusCode()
        );
    }
}
