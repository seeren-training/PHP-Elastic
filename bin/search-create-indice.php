#!/usr/bin/env php
<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

require_once __DIR__ . "/../vendor/autoload.php";

$client = new Client();

try {
  $response = $client->post('http://host.docker.internal:9000/search/indices', [
    'json' => [
      'index' => 'products',
      'body' => [
        "settings" => ["number_of_replicas" => 0],
        "mappings" => [
          "properties" => [
            "autocomplete" => [
              "type" => "search_as_you_type"
            ],
            "suggest" => [
              "type" => "completion"
            ],
            "name" => [
              "type" => "text"
            ],
            "description" => [
              "type" => "text"
            ],
            "filters" => [
              "type" => "object",
              "properties" => [
                "category" => [
                  "type" => "text",
                  "fields" => [
                    "keyword" => [
                      "type" => "keyword",
                    ]
                  ]
                ],
                "brand" => [
                  "type" => "text",
                  "fields" => [
                    "keyword" => [
                      "type" => "keyword",
                    ]
                  ]
                ],
                "colors" => [
                  "type" => "text",
                  "fields" => [
                    "keyword" => [
                      "type" => "keyword",
                    ]
                  ]
                ],
                "price" => [
                  "type" => "float",
                  "fields" => [
                    "keyword" => [
                      "type" => "keyword",
                    ]
                  ]
                ],
              ]
            ],
          ],
        ]
      ]
    ],
  ]);
  echo 'Indice "products" created' . "\n";
} catch (ClientException $ex) {
  echo 'Indice "products" creation fail: ' . $ex->getResponse()->getStatusCode() . "\n";
}
