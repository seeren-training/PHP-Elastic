#!/usr/bin/env php
<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

require_once __DIR__ . "/../vendor/autoload.php";

$products = require __DIR__ . '/fixtures-provider.php';

$colors = [];

foreach ($products as $product) {
  foreach ($product->product_colors as $color) {
    $hexa = strtoupper($color->hex_value);
    if (in_array($hexa, $colors)) {
      continue;
    }
    $colors[$color->colour_name] = $hexa;
  }
}

echo 'Color creation' . "\n";

$client = new Client();
$progressBar = new ProgressBar(new ConsoleOutput(), count($colors));
$progressBar->start();

foreach ($colors as $name => $hexa) {
  try {
    $client->post('http://host.docker.internal:9000/colors', [
      'json' => [
        'name' => $name,
        'hex' => $hexa,
      ]
    ]);
  } catch (ClientException $ex) {
  } finally {
    $progressBar->advance();
  }
}

echo "\n";
