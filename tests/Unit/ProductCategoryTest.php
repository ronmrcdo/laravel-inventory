<?php

namespace Ronmrcdo\Inventory\Tests\Unit;

use Ronmrcdo\Inventory\Models\Category;
use Ronmrcdo\Inventory\Models\Product;
use Ronmrcdo\Inventory\Tests\TestCase;

class ProductCategoryTest extends TestCase
{
	/** @test */
	public function itShouldHaveCategory()
	{
		$category = factory(Category::class)->create();
		$product = factory(Product::class)->create([
			'category_id' => $category->id
		]);

		$this->assertEquals($category->name, $product->category->name, 'Category should be attached to product');
	}

	/** @test */
	public function itShouldHaveChildCategory()
	{
		$parentCategory = factory(Category::class)->create();
		$childCategory = factory(Category::class)->create([
			'parent_id' => $parentCategory->id
		]);

		$this->assertEquals($parentCategory->name, $childCategory->parent->name, 'Parent should equal');
		$this->assertTrue(! $childCategory->isParent(), 'Is Parent should return false');
	}

	/** @test */
	public function itShouldListProductsByCategory()
	{
		$category = factory(Category::class)->create();
		$products = factory(Product::class, rand(10,20))->create([
			'category_id' => $category->id
		]);

		$this->assertEquals(sizeof($products->toArray()), sizeof($category->products->toArray()), 'It should have the same length');
	}
}