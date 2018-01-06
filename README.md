# pricing-lamps-and-wallets

## 可以比較index-before.php 和 index-after.php 兩種寫法的可讀性之間的差異
### index-before.php 是傳統PHP的寫法

```php
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
```

### index-after.php 是採用refactoring to collections

```php
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
```