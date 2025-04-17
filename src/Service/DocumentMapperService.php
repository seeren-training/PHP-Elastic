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

}
