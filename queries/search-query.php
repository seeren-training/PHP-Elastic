<?php

return [
    'query' => [
        'multi_match' => [
            'query' => $search,
            'fuzziness' => 'AUTO',
            'fields' => ['name^2', 'description']
        ],
    ],
] + require __DIR__ . '/search-query-aggs.php';
