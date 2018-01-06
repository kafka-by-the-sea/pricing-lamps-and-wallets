<?php

require_once 'vendor/autoload.php';

function load_json($path)
{
    return json_decode(file_get_contents(__DIR__.'/'.$path), true);
}

$products = collect(load_json('products.json')['products']);

$totalCost = $products->filter(function ($product) {
    return collect(['Lamp', 'Wallet'])->contains($product['product_type']);
})->flatMap(function ($product) {
    return $product['variants'];
})->sum('price');

dd($totalCost);