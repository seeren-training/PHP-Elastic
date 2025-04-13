#!/usr/bin/env php
<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

require_once __DIR__ . "/../vendor/autoload.php";

$products = require __DIR__ . '/fixtures-provider.php';

$categories = [];

foreach ($products as $product) {
  $category = strtoupper($product->category);
  if (!$category || in_array($category, $categories)) {
    continue;
  }
  $categories[] = $category;
}

echo 'Category creation' . "\n";

$client = new Client();
$progressBar = new ProgressBar(new ConsoleOutput(), count($categories));
$progressBar->start();

foreach ($categories as $category) {
  try {
    $client->post('http://host.docker.internal:9000/categories', [
      'json' => [
        'name' => $category,
      ]
    ]);
  } catch (ClientException $ex) {
  } finally {
    $progressBar->advance();
  }
}

echo "\n";
