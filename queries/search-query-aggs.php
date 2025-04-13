<?php

$aggs = require __DIR__ . '/../config/aggs.php';

$postFilters = require __DIR__ . '/search-query-filters.php';

$filtredBuckets = [];
$buckets = [];

foreach ($aggs['buckets'] as $bucket) {
    $buckets[$bucket] = [
        'terms' => [
            'field' => "filters.$bucket.keyword",
            'size' => 100
        ]
    ];
    if ($search || $filters) {
        $bucketFilter = ['terms' => []];
        foreach ($filters as $filterName => $filterValues) {
            if ($filterName !== $bucket) {
                $bucketFilter['terms'] = ["filters.$filterName.keyword" => $filterValues];
            }
        }
        if (count($bucketFilter['terms'])) {
            $filtredBuckets["filtred_$bucket"] = [
                'filter' => [
                    'bool' => [
                        'must' => [
                            [...$bucketFilter]
                        ]
                    ],

                ],
                'aggs' => [
                    $bucket => $buckets[$bucket]
                ]
            ];
        } else {
            $filtredBuckets[$bucket] = $buckets[$bucket];
        }
    }
}

return $postFilters + [
    'aggs' => [
        ...$filtredBuckets,
        'filters' => [
            'global' => new stdClass(),
            'aggs' => [
                ...$buckets
            ]
        ]
    ]
];
