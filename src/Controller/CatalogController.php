<?php

namespace App\Controller;

use App\Service\ProductService;
use Seeren\Controller\HTMLController;
use Seeren\Router\Route\Route;

class CatalogController extends HTMLController
{

    #[Route("/catalog", "GET")]
    public function index(ProductService $productService)
    {
        $params = $this->getRequest()->getQueryParams();

        [$count, $limit, $offset, $products, $filters] = $productService->getProducts(
            page: max((int) ($params['page'] ?? 1), 1),
            search: $params['search'] ?? null,
            filters: $params['filters'] ?? null
        );

        return $this->render('index.html.php', [
            'count' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'products' => $products,
            'filters' => $filters,
            'params' => $params,
        ]);
    }
}
