# Category

Creating a category

```php
use Ronmrcdo\Inventory\Models\Category;

Category::create([
    'name' => 'test-category',
    'description' => 'Lorem ipsum...',
    'parent_id' => null
]);
```

Creating a category and sub category

```php
use Ronmrcdo\Inventory\Models\Category;

$parent = Category::create([
    'name' => 'Test-Parent',
    'description' => 'Lorem ipsum...',
    'parent_id' => null
]);

$child1 = $parent->children()->create([
    'name' => 'Test-Child-1',
    'description' => 'Lorem ipsum...',
]);

$child2 = $parent->children()->create([
    'name' => 'Test-Child-2',
    'description' => 'Lorem ipsum...',
]);
```

## Category built-in functions

```php

// Assert if the category has this product
// @param mixed (string|int) product->name or product->id
$category->hasProduct($product);

// Assert if the category has this product by sku
// @param string $sku
$category->hasProductBySku($sku);