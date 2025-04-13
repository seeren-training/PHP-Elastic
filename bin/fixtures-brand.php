#!/usr/bin/env php
<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

require_once __DIR__ . "/../vendor/autoload.php";

$products = require __DIR__ . '/fixtures-provider.php';

$brands = [];

foreach ($products as $product) {
  $brand = strtoupper($product->brand);
  if (!$brand || in_array($brand, $brands)) {
    continue;
  }
  $brands[] = $brand;
}

echo 'Brand creation' . "\n";

$client = new Client();
$progressBar = new ProgressBar(new ConsoleOutput(), count($brands));
$progressBar->start();

foreach ($brands as $brand) {
  try {
    $client->post('http://host.docker.internal:9000/brands', [
      'json' => [
        'name' => $brand,
      ]
    ]);
  } catch (ClientException $ex) {
  } finally {
    $progressBar->advance();
  }
}

echo "\n";
