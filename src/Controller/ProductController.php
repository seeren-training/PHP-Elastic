<?php

namespace App\Controller;

use App\Service\ProductService;
use Seeren\Controller\JsonController;
use Seeren\Router\Route\Route;

class ProductController extends JsonController
{

    #[Route("/products/(\d+)", "GET")]
    public function show(int $id, ProductService $productService)
    {
        return $this->render($productService->getProduct($id));
    }

    #[Route("/products", "POST")]
    public function create(ProductService $productService)
    {
        $payload = $this->getRequest()->getParsedBody();

        return $this->render($productService->createProduct(
            $payload['name'],
            $payload['description'],
            $payload['imageLink'],
            $payload['price'],
            $payload['brand'],
            $payload['category'],
            $payload['colors'],
        ), 201);
    }
}
