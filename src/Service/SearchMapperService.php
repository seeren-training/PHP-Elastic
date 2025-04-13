<?php

namespace App\Service;


use Psr\Http\Message\ResponseInterface;

class SearchMapperService
{

    public function mapId(
        ResponseInterface $response,
        int $limit
    ): array {
        return array_slice(array_map(
            fn(array $hit) => (int) $hit['_id'],
            $response['hits']['hits']
        ), 0, $limit);
    }

    public function mapField(
        ResponseInterface $response,
        string $field,
        int $limit
    ): array {
        return array_slice(array_map(
            fn(array $hit) => current($hit['fields'][$field]),
            $response['hits']['hits']
        ), 0, $limit);
    }

    public function mapSuggest(
        ResponseInterface $response,
        string $suggest,
        int $limit
    ): array {
        $options = [];

        foreach ($response['suggest'][$suggest] as $value) {
            $options += array_map(
                fn(array $option) => $option['text'],
                $value['options']
            );
        }

        return array_slice($options, 0, $limit);
    }

    public function mapFilters(
        ResponseInterface $response,
        string $aggName,
        ?array $queryFilters,
    ): array {
        $filters = [];

        foreach ($response['aggregations'] as $aggregationKey => $aggregationValue) {
            if ($aggregationKey !== 'doc_count' && $aggregationKey !== $aggName) {
                $aggregationKey = str_replace('filtred_', '', $aggregationKey);
                $filters[$aggregationKey] = [];
                foreach (
                    isset($aggregationValue['buckets'])
                        ? $aggregationValue['buckets']
                        : $aggregationValue[$aggregationKey]['buckets'] as $bucket
                ) {
                    $filters[$aggregationKey][$bucket['key']] = $bucket['doc_count'];
                }
            }
        }

        foreach ($response['aggregations'][$aggName] as $aggregationKey => $aggregationValue) {
            if ($aggregationKey !== 'doc_count') {
                $aggregationKey = str_replace('filtred_', '', $aggregationKey);
                // var_dump($filters[$aggregationKey]);
                foreach ($aggregationValue['buckets'] as $bucket) {
                    if ($queryFilters || isset($filters[$aggregationKey])) {
                        $filters[$aggregationKey][$bucket['key']] += 0;
                    } else {
                        $filters[$aggregationKey][$bucket['key']] = $bucket['doc_count'];
                    }
                }
            }
        }

        ksort($filters);

        return $filters;
    }
}
