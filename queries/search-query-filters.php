<?php

$must = [];

foreach ($filters as $filterName => $filterValues) {
    $must[] = [
        'terms' => [
            "filters.$filterName.keyword" => $filterValues
        ]
    ];
}

return count($must) ? [
    "post_filter" => [
        "bool" => [
            "must" => $must
        ]
    ],
] : $must;
