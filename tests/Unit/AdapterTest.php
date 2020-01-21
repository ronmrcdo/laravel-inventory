<?php

namespace Ronmrcdo\Inventory\Tests\Unit;

use Ronmrcdo\Inventory\Models\Product;
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