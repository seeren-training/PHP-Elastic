<?php

namespace App\Service;

use App\Entity\Color;
use App\Entity\Product;

class ProductSearchService
{
    private const BODY = [
        '_source' => false,
        'size' => 1000,
    ];

    public function __construct(
        private SearchService $searchService,
        private SearchMapperService $searchMapperService
    ) {}

    public function searchProductIds(
        int $offset,
        int $limit,
        ?string $search,
        ?array $filters,
    ): array {

        $query = ($search
            ? require __DIR__ . '/../../queries/search-query.php'
            : require __DIR__ . '/../../queries/search-query-aggs.php');

        $response = $this->searchService->searchDocuments(
            'products',
            [
                ...self::BODY,
                "from" => $offset,
            ] + $query
        );

        return [
            $response['hits']['total']['value'],
            $this->searchMapperService->mapId($response, $limit),
            $this->searchMapperService->mapFilters($response, 'filters', $filters)
        ];
    }

    public function getAutocomplete(
        string $search,
        int $limit = 5,
    ): array {
        $response = $this->searchService->searchDocuments('products', [
            ...self::BODY,
            'fields' => ['name'],
        ] + require __DIR__ . '/../../queries/autocomplete-query.php');

        return [
            'results' => $this->searchMapperService->mapField(
                $response,
                'name',
                $limit
            ),
            'suggest' => [
                'completions' => $this->searchMapperService->mapSuggest(
                    $response,
                    'completion-suggest',
                    $limit
                ),
                'terms' => $this->searchMapperService->mapSuggest(
                    $response,
                    'term-suggest',
                    $limit
                )
            ],
        ];
    }

    public function indexProduct(Product $product): Product
    {
        $this->searchService->createDocument(
            'products',
            $product->getId(),
            [
                'autocomplete' => strtolower($product->getName()),
                'suggest' => [$product->getName()],
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'filters' => [
                    'price' => $product->getPrice(),
                    'brand' => $product->getBrand()->getName(),
                    'category' => $product->getCategory()->getName(),
                    'colors' => array_map(
                        fn(Color $color) => $color->getHex(),
                        [...$product->getColors()]
                    ),
                ]
            ]
        );

        return $product;
    }
}
