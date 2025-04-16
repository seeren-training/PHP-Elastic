<?php

namespace App\Controller;

use App\Service\IndiceService;
use Seeren\Controller\JsonController;
use Seeren\Router\Route\Route;

class IndiceController extends JsonController
{
    #[Route("/search/indices", "POST")]
    public function create(IndiceService $indiceService)
    {
        $payload = $this->getRequest()->getParsedBody();

        $response = $indiceService->createIndice($payload);

        return $this->render(
            (string) $response->getBody(), 
            $response->getStatusCode()
        );
    }
}
