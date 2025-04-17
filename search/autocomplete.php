<?php

return [
  'query' => [
    'multi_match' => [
      'query' => $search,
      'type' => 'bool_prefix',
      'fields' => [
        'name_search_as_you_type',
        'name_search_as_you_type._2gram',
        'name_search_as_you_type._3gram'
      ]
    ]
  ],
  'suggest' => [
    'completion-suggest' => [
      'prefix' => $search,
      'completion' => [
        'field' => 'name_completion',
        'fuzzy' => [
          'fuzziness' => 1
        ]
      ]
    ],
    'term-suggest' => [
      'text' => $search,
      'term' => [
        'field' => 'name'
      ]
    ]
  ]
];