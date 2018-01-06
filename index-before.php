<?php

require_once 'vendor/autoload.php';

function load_json($path)
{
    return json_decode(file_get_contents(__DIR__.'/'.$path), true);
}

$products = load_json('products.json')['products'];


$totalCost = 0;

foreach ($products as $product) {
    $productType = $product['product_type'];
    if ($productType == 'Lamp' || $productType == 'Wallet') {
        foreach ($product['variants'] as $productVariant) {
            $totalCost += $productVariant['price'];
        }
    }
}
return $totalCost;

dd($totalCost);