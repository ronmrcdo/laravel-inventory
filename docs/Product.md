## Creating a Product

Creating the main product

```php
use Ronmrcdo\Inventory\Models\Product;

Product::create([
    'name' => 'Test Product',
    'short_description' => 'Lorem ipsum...',
    'description' => 'Lorem ipsum dolor ...',
    'category_id' => 1, // Category Model
    'is_active' => true
]);

```

