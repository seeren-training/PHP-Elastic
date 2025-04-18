<?php

namespace App\Service;

use Psr\Http\Message\ResponseInterface;

class DocumentMapperService
{

    public function mapIds(ResponseInterface $response): array
    {
        $hits = $response['hits'];

        return [
            $hits['total']['value'],
            array_map(
                fn($hit) => $hit['_id'],
                $hits['hits']
            )
        ];

    }

    public function mapAutocomplete(
        ResponseInterface $response,
        int $size
    ): array {
        $hits = $response['hits'];
        $suggests = $response['suggest'];

        return [
            'results' => array_slice(array_map(
                fn($hit) => current($hit['fields']['name_search_as_you_type']),
                $hits['hits']
            ), 0, $size),
            'completions' => array_slice(array_map(
                fn($option) => $option['text'],
                current($suggests['completion-suggest'])['options']
            ), 0, $size),
            'corrections' => array_slice(array_map(
                fn($option) => $option['text'],
                current($suggests['term-suggest'])['options']
            ), 0, $size),
        ];
    }

    public function mapFilters(ResponseInterface $response): array
    {
        $filters = [];
        $aggregations = $response['aggregations'];

        foreach ($aggregations as $filterName => $filterValues) {
            if ($filterName !== 'filters') {
                $filters[$filterName] = [];
                foreach ($filterValues['buckets'] as $filterValue) {
                    $filters[$filterName][$filterValue['key']] = $filterValue['doc_count'];
                }
            }
        }

        foreach ($aggregations['filters'] as $filterName => $filterValues) {
            if ($filterName !== 'doc_count') {
                foreach ($filterValues['buckets'] as $filterValue) {
                    $filters[$filterName][$filterValue['key']] ??= 0;
                }
            }
        }

        return $filters;
    }


}
