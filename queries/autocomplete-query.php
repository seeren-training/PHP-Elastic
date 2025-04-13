<?php

$searchToLower = strtolower($search);

return [
    'query' => [
        'multi_match' => [
            'query' => $searchToLower,
            'type' => 'bool_prefix',
            'fields' => [
                'autocomplete',
                'autocomplete._2gram',
                'autocomplete._3gram',
            ]
        ]
    ],
    'suggest' => [
        'completion-suggest' => [
            'prefix' => $search,
            'completion' => [
                'field' => 'suggest',
                'fuzzy' => ['fuzziness' => 1],
                'size' => 10,
            ]
        ],
        'term-suggest' => [
            'text' => $search,
            'term' => ['field' => 'name']
        ]
    ],
];
