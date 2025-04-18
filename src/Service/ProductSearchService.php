<?php

namespace App\Service;

use App\Entity\Product;
use RuntimeException;

class ProductSearchService
{

    public function __construct(
        private DocumentService $documentService,
        private DocumentMapperService $documentMapperService,
    ) {
    }

    public function searchIds(
        int $offset,
        int $limit,
        ?string $search
    ): array {
        $query = [
            '_source' => false,
            'from' => $offset,
            'size' => $limit,
        ] + ($search
            ? require __DIR__ . '/../../search/multi-match.php'
            : require __DIR__ . '/../../search/aggs.php');

        $response = $this->documentService->searchDocument(
            'products',
            $query
        );


        [$count, $ids] = $this->documentMapperService->mapIds($response);
        $filters = $this->documentMapperService->mapFilters($response);

        return [$count, $ids, $filters];
    }

    public function indexProduct(Product $product): Product
    {
        $response = $this->documentService->createDocument(
            'products',
            $product->getId(),
            [
                'name' => $product->getName(),
                'name_search_as_you_type' => $product->getName(),
                'name_completion' => ['input' => [$product->getName()]],
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
