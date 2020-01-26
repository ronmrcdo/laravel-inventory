# Product Variation

In able to create a product variation, product should have attribute and attribute term

## Creating variation

If the attributes or terms doesn't exist in the product attributes, it will throw an ```InvalidAttributeException``` and if the variation attribute already exist in the product it will throw an ```InvalidVariantException```

```php
$variant = [
    'sku' => 'TSHIRT-SMBLK',
    'price' => 10.00,
    'cost' => 5.00,
    'variation' => [
        ['option' => 'color', 'value' => 'black'],
        ['option' => 'size', 'value' => 'small'],
    ]
];

$product->addVariant($variant);
```

## ProductVariantAdapter

Using an adapter to transform into readable format. Take note: that it will transform it into array format

```php

use Ronmrcdo\Inventory\Adapters\ProductVariantAdapter;

$variantResource = new ProductVariantAdapter($product->findBySku('TSHIRT-SMBLK'))

$variantResource->transform();
```

Output will be

```php
[
    "id" => 2
    "parent_product_id" => "1"
    "sku" => "TSHIRT-SMBLK"
    "name" => "harum"
    "short_description" => "Alias pariatur ab ut. Qui odit et qui placeat minus nulla voluptas. Possimus officia maxime in qui iste velit. Ex nesciunt quisquam iure rerum odio. Aut voluptas voluptatum sed."
    "description" => "Atque incidunt nostrum repellat cumque facilis. Reprehenderit dolorum nihil aut sed dolores dicta deserunt. Reprehenderit nisi aperiam velit vel et sit provident. Et nisi aperiam animi asperiores corporis architecto. Molestias velit ab esse quidem minima. Quod et quibusdam tempora laboriosam consequatur qui. Possimus ut sequi quam animi quos itaque et nobis. Accusamus minima ea et ex labore et similique. Amet repellendus distinctio consectetur error. Aliquam facere deserunt veritatis qui deleniti."
    "price" => "10"
    "cost" => "5"
    "category" => [
        "id" => "1"
        "name" => "est quis"
    ]
    "attributes" => [
    [
        "name" => "color"
        "option" => "white"
    ],
    [
        "name" => "size"
        "option" => "small"
    ]
]
```

For collections or list of variations

```php
use Ronmrcdo\Inventory\Adapters\ProductVariantAdapter;

$variantResource = ProductVariantAdapter::collection($product->getVariations());

return $variantResource;
```

### Product built-in functions or helpers

```php

// Return the variations in collection/model instance
$product->getVariations();

// Static function that will get the product variation
Product::findBySku($sku);
```