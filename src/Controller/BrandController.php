<?php

namespace App\Controller;

use App\Service\BrandService;
use Seeren\Controller\JsonController;
use Seeren\Router\Route\Route;

class BrandController extends JsonController
{

    #[Route("/brands", "POST")]
    public function create(BrandService $brandService)
    {
        $payload = $this->getRequest()->getParsedBody();

        $brandService->createBrand(
            $payload['name'],
        );

        return $this->render([], 201);
    }
}
