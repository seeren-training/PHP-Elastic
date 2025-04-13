<?php

namespace App\Controller;

use App\Service\CategoryService;
use Seeren\Controller\JsonController;
use Seeren\Router\Route\Route;

class CategoryController extends JsonController
{

    #[Route("/categories", "POST")]
    public function create(CategoryService $categoryService)
    {
        $payload = $this->getRequest()->getParsedBody();

        $categoryService->createCategory(
            $payload['name'],
        );

        return $this->render([], 201);
    }
}
