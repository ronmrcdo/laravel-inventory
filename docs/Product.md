# Creating a Product

Creating a simple product

Product that doesn't have attributes. It's really a good thing to wrap your code in transaction.

```php

use Illuminate\Support\Facades\DB;
use Ronmrcdo\Inventory\Models\Product;

...

DB::beginTransaction();

try {
    $product = Product::create([
        'name' => 'Test Product',
        'short_description' => 'Lorem ipsum...',
        'description' => 'Lorem ipsum dolor ...',
        'category_id' => 1, // Category Model
        'is_active' => true
    ]);

    $product->addSku('TESTPRODUCT1', 9.00, 4.00);

    DB::commit();
} catch (\Throwable $err) {
    DB::rollBack();

}
```

Wrapping your product for the desired output
<b>Note:</b> This will convert the product into array

```php
use Ronmrcdo\Inventory\Adapters\ProductAdapter;

$productResource = new ProductAdapter($product);

return $productResource->transform();
```

it will return into this format

```php
[
  "id" => 1
  "name" => "aut"
  "slug" => "aut"
  "sku" => "3vUfh6xi8hNhRaMv"
  "short_description" => "Recusandae est quo est exercitationem suscipit ipsam possimus. Voluptatibus sit unde laboriosam fugiat exercitationem rerum assumenda. Exercitationem esse minus corporis voluptatem debitis iure aut. Eum est eius qui iusto porro aut a distinctio. In saepe quia at ut sit reprehenderit."
  "description" => "Ea rerum omnis et magni ea quo nam. Debitis sapiente facere rerum unde magnam. A qui modi est ut cupiditate placeat. Ipsa magnam laboriosam voluptatem eaque consequatur ducimus. Rerum cum doloribus consequatur soluta in ut totam aliquid. Quod totam voluptas sed in praesentium enim quam id. Deleniti id modi et fugiat reprehenderit doloribus. Consequuntur reiciendis aut dolore accusamus sed rerum. Sit aut quae et voluptatum. Accusantium nihil molestias aut mollitia."
  "price" => "45.00"
  "cost" => "23.00"
  "is_active" => true
  "category" => [
    "id" => 1
    "name" => "illum architecto eveniet"
  ]
  "attributes" => []
  "variations" => []
]

```

so basically this class function is to transform into readable format

## Slugs

Product and category model will automatically generate slugs when creating or updating the name.

## Product built-in functions

```php
// return a bool if the product has an sku no matter if it's a variation sku
$product->hasSku(); 

// static function that will return a Product Sku Model
// you could wrap it with Product adapter by using
$sku = Product::findBySku($sku);

$productAdapter = (new ProductAdapter($sku->product))->transform();

// Local Scope to find product by sku. Noted, it will return the parent product

$product = Product::whereSku($sku)->firstOrFail();


```
