# Product

In this example we will show you on how to create a product that doesn't have a variation.

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

## Product built-in functions

```php
// return a bool if the product has an sku no matter if it's a variation sku
$product->hasSku(); 

// static function that will return a Product Sku Model
$sku = Product::findBySku($sku);

// Local Scope to find product by sku. Noted, it will return the parent product
$product = Product::whereSku($sku)->firstOrFail();
```

## Extending Product and Category Model

If you want to extend the product and category model like, adding attributes
you can edit the config of laravel-inventory to use your product model and just
extend the package product/category model

ex.
```php
<?php

return [
    /**
     * Base Product class
     * 
     */
    'product' => \Your\Namespace\Product::class,

    /**
     * Base Category Class
     * 
     */
    'category' => \Your\Namespace\Category::class
];
```

then in your Product model class

```php
<?php

namespace Your\Namespace;

use Ronmrcdo\Inventory\Models\Product as BaseProduct;

class Product extends BaseProduct
{
    protected $fillable = [
        //
    ];
}

>
```

same with the category class