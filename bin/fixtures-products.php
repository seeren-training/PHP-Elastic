#!/usr/bin/env php
<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

require_once __DIR__ . "/../vendor/autoload.php";

$products = require __DIR__ . '/fixtures-provider.php';

$makeupProducts = [];

foreach ($products as $product) {
  if (!$product->category || !$product->brand || !$product->price) {
    continue;
  }
  $makeupProducts[] = $product;
}

echo 'Product creation' . "\n";

$client = new Client();
$progressBar = new ProgressBar(new ConsoleOutput(), count($makeupProducts));
$progressBar->start();

foreach ($makeupProducts as $makeupProduct) {
  try {
    $response = $client->post('http://host.docker.internal:9000/products', [
      'json' => [
        'name' => $makeupProduct->name,
        'description' => $makeupProduct->description,
        'imageLink' => $makeupProduct->image_link,
        'price' => $makeupProduct->price,
        'brand' => $makeupProduct->brand,
        'category' => $makeupProduct->category,
        'colors' => array_map(fn($color) => $color->hex_value, $makeupProduct->product_colors ?? []),
      ]
    ]);
  } catch (ClientException $ex) {
  } finally {
    $progressBar->advance();
  }
}

echo "\n";
