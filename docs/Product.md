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

