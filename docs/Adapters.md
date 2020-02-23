# Adapters

Using adapters to transform it into array with similar structure from woocommerce product.

## Product Adapter

```php
use Ronmrcdo\Inventory\Models\Product;
use Ronmrcdo\Inventory\Adapters\ProductAdapter;

$product = Product::create([
    'name' => 'Test Product',
    'short_description' => 'Lorem ipsum...',
    'description' => 'Lorem ipsum dolor ...',
    'category_id' => 1, // Category Model
    'is_active' => true
]);

$product->addSku('TESTPRODUCT1', 9.00, 4.00);

$productResource = new ProductAdapter($product);

return $productResource->transform();
```

return array format

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

if the product has an attribute and variations, it will return an array like this.

Output
```php
 [
  "id" => 1
  "name" => "veniam quasi"
  "slug" => "veniam-quasi"
  "sku" => "WOOPROTSHIRT-SMBLK"
  "short_description" => "Tempore rerum ratione tempora nulla. Blanditiis sit delectus consequatur tenetur. Ut iure quasi pariatur illo praesentium. Natus atque aut est non dolores. Qui quae ullam natus velit et."
  "description" => "Omnis consequatur suscipit aut sed. Ad molestiae architecto a consequatur necessitatibus. Voluptatibus ut fugit ducimus ipsum atque maxime quae. Libero error est atque a. Corporis aut sapiente sed minima aut suscipit corporis illum. Illum expedita autem itaque. Nostrum ab quia officia id eum maiores aut. Voluptas et rem eum unde. Provident eos sequi aliquam est occaecati omnis. Libero ratione sapiente laborum et praesentium enim quis omnis."
  "price" => "156"
  "cost" => "156"
  "is_active" => true
  "category" => [
    "id" => 1
    "name" => "possimus eaque dolorum"
  ]
  "attributes" => [
    [
      "id" => 1
      "name" => "size"
      "options" => [
        "small",
        "medium",
        "large"
      ]
    ],
    [
      "id" => 2
      "name" => "color"
      "options" => [
        "black",
        "white"
      ]
    ]
  ]
  "variations" => [
    [
      "id" => 1
      "parent_product_id" => "1"
      "sku" => "WOOPROTSHIRT-SMBLK"
      "name" => "veniam quasi"
      "short_description" => "Tempore rerum ratione tempora nulla. Blanditiis sit delectus consequatur tenetur. Ut iure quasi pariatur illo praesentium. Natus atque aut est non dolores. Qui quae ullam natus velit et."
      "description" => "Omnis consequatur suscipit aut sed. Ad molestiae architecto a consequatur necessitatibus. Voluptatibus ut fugit ducimus ipsum atque maxime quae. Libero error est atque a. Corporis aut sapiente sed minima aut suscipit corporis illum. Illum expedita autem itaque. Nostrum ab quia officia id eum maiores aut. Voluptas et rem eum unde. Provident eos sequi aliquam est occaecati omnis. Libero ratione sapiente laborum et praesentium enim quis omnis."
      "price" => "156"
      "cost" => "61"
      "category" => [
        "id" => "1"
        "name" => "possimus eaque dolorum"
      ]
      "attributes" => [
        [
          "name" => "color"
          "option" => "black"
        ],
        [
          "name" => "size"
          "option" => "small"
        ]
      ]
    ],
    [
      "id" => 2
      "parent_product_id" => "1"
      "sku" => "WOOPROTSHIRT-SMWHT"
      "name" => "veniam quasi"
      "short_description" => "Tempore rerum ratione tempora nulla. Blanditiis sit delectus consequatur tenetur. Ut iure quasi pariatur illo praesentium. Natus atque aut est non dolores. Qui quae ullam natus velit et."
      "description" => "Omnis consequatur suscipit aut sed. Ad molestiae architecto a consequatur necessitatibus. Voluptatibus ut fugit ducimus ipsum atque maxime quae. Libero error est atque a. Corporis aut sapiente sed minima aut suscipit corporis illum. Illum expedita autem itaque. Nostrum ab quia officia id eum maiores aut. Voluptas et rem eum unde. Provident eos sequi aliquam est occaecati omnis. Libero ratione sapiente laborum et praesentium enim quis omnis."
      "price" => "255"
      "cost" => "93"
      "category" => [
        "id" => "1"
        "name" => "possimus eaque dolorum"
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
    ]
  ]
]
```

using the ProductAdapter as ```collection```

```php
use Ronmrcdo\Inventory\Models\Product;
use Ronmrcdo\Inventory\Adapters\ProductAdapter;

$product = Product::all();

$productResourceCollection = ProductAdapter::collection($product);

return $productResourceCollection;

```

## Product Variant Adapter

```php
use Ronmrcdo\Inventory\Adapters\ProductVariantAdapter;

$variantResource = ProductVariantAdapter::collection($product->getVariations());

return $variantResource;
```


## ProductVariantAdapter

ProductVariantAdapter only transform the product variation into array similar to the above functionality.

```php
use Ronmrcdo\Inventory\Adapters\ProductVariantAdapter;

$variantResource = new ProductVariantAdapter($product->findBySku('TSHIRT-SMBLK'))

$variantResource->transform();
```

It will return an array format like this

```php
[
    "id" => 2
    "parent_product_id" => "1"
    "sku" => "TSHIRT-SMWHT"
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

Using collection to list all the product variation and convert them into array format

```php
use Ronmrcdo\Inventory\Adapters\ProductVariantAdapter;

$variations = $product->getVariations();
$variantResource = ProductVariantAdapter::collection($variations);
```

it will return a collection of variant in array format

```php
[
  0 => [
    "id" => 2
    "parent_product_id" => "1"
    "sku" => "TSHIRT-SMWHT"
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
  ],
  1 => [
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
        "option" => "black"
    ],
    [
        "name" => "size"
        "option" => "small"
    ]
  ]
]
```

## Extending the Adapters

If you want to extend or modify the adapters you can create your own new resource
and use the BaseAdapter

```php
<?php

namespace Your\Namespace;

use Ronmrcdo\Inventory\Adapters\BaseAdapter;
use Your\Namespace\Resources\ProductResource;

class ProductAdapter extends BaseAdapter
{
    /**
     * Single resource transformer
     * 
     * @param mixed $model
     */
    public function __construct($model)
    {
        parent::__construct(new ProductResource($model));
    }

    /**
     * Static function for the collection
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return array
     */
    public static function collection($collection): array
    {
        $resource = new self($collection);
        $resource->setResource(ProductResource::collection($collection));

        return $resource->transform();
    }
}

>