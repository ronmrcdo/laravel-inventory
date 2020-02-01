# Product Variation

To create a product variation, product should have attribute and attribute term

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

### Product built-in functions for variations

```php

// Return the variations in collection/model instance
$product->getVariations();

// Static function that will get the product variation
Product::findBySku($sku);
```