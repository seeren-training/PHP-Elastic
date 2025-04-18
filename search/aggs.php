<?php

$aggsFilters = require __DIR__ . "/../config/filters.php";

$aggs = [];

foreach ($aggsFilters as $aggsFilter) {
  $aggs[$aggsFilter] = [
    "terms" => [
      "field" => "$aggsFilter.keyword"
    ]
  ];
}

return [
  "aggs" => $aggs + [
    "filters" => [
      "global" => new stdClass(),
      "aggs" => $aggs
    ]
  ],
];
