<?php

namespace Ronmrcdo\Inventory\Tests\Unit;

use Ronmrcdo\Inventory\Models\Product;
use Ronmrcdo\Inventory\Models\Attribute;
use Ronmrcdo\Inventory\Models\AttributeValue;
use Ronmrcdo\Inventory\Tests\TestCase;
use Ronmrcdo\Inventory\Adapters\ProductAdapter;

class AdapterTest extends TestCase
{
	/** @test */
	public function itShouldReturnArrayResource()
	{
		$product = factory(Product::class)->create();

		$productResource = new ProductAdapter($product);

		$this->assertArrayHasKey('slug', $productResource->transform(), 'It should return the resource');
		$this->assertArrayHasKey('category', $productResource->transform(), 'It should have keys');
	}

	/** @test */
	public function itShouldReturnArrayResourceWithAttributes()
	{
		$product = factory(Product::class)->create();
		$size = rand(2,4);
		$attributes = factory(Attribute::class, $size)->make();

		$product->addAttributes($attributes->toArray());

		$product->attributes->each(function ($attribute) {
			$terms = factory(AttributeValue::class, 3)->make();
			$terms->each(function ($term) use ($attribute) {
				$attribute->addValue($term->value);
			});
		});

		$productResource = new ProductAdapter($product);

		$this->assertArrayHasKey('attributes', $productResource->transform(), 'It should have an attributes');
		$this->assertArrayHasKey('category', $productResource->transform(), 'It should have keys');
	}

	/** @test */
	public function itShouldReturnCollectionResource()
	{
		$size = rand(5, 10);
		$products = factory(Product::class, $size)->create();
		$productsCollection = ProductAdapter::collection($products);
        $selected = sizeof($productsCollection) < 1 ? 0 : rand(0, sizeof($productsCollection) - 1);

		$this->assertArrayHasKey('slug', $productsCollection[$selected], 'It should have slug');
		$this->assertEquals($size, sizeof($productsCollection), 'Collection should match the random size');
	}
}