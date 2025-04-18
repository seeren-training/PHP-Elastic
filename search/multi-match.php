<?php

return [
  'query' => [
    'multi_match' => [
      'query' => $search,
      'fields' => ['name^2', 'description'],
      'fuzziness' => 'AUTO'
    ]
  ]
] + require __DIR__ . '/aggs.php';
