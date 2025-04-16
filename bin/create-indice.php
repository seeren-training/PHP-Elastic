#!/usr/bin/env php
<?php

use GuzzleHttp\Client;

require_once __DIR__ . "/../vendor/autoload.php";

echo 'Indice creation' . "\n";

$client = new Client();

$reponse = $client->post('http://host.docker.internal:9000/search/indices', [
  'json' => [
    'index' => 'products',
    'body' => file_get_contents(__DIR__ . '/../search/indice.json')
  ]
]);

echo 'Indice created' . "\n";
