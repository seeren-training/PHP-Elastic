<?php

namespace App\Service;

use App\Entity\Product;
use RuntimeException;

class ProductSearchService
{

    public function __construct(private DocumentService $documentService)
    {
    }

    public function indexProduct(Product $product): Product
    {
        $response = $this->documentService->createDocument(
            'products',
            $product->getId(),
            [
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'category' => $product->getCategory()->getName(),
                'brand' => $product->getBrand()->getName(),
                'colors' => array_map(
                    fn($color) => $color->getHex(),
                    $product->getColors()->toArray()
                )
            ]
        );

        if ($response->getStatusCode() !== 201) {
            throw new RuntimeException((string) $response->getBody());
        }

        return $product;
    }

}
