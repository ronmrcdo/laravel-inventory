<?php

namespace Ronmrcdo\Inventory\Tests\Unit;

use Ronmrcdo\Inventory\Models\Category;
use Ronmrcdo\Inventory\Tests\TestCase;

class ModelSluggableTest extends TestCase
{
	/** @test */
	public function itShouldGenerateSlug()
	{
		$category = factory(Category::class)->create();

		$this->assertTrue(! is_null($category->slug), 'It should be true');
	}

	/** @test */
	public function itShouldIncrementSlug()
	{
		$category1 = factory(Category::class)->create();
		$category2 = factory(Category::class)->create([
			'name' => $category1->name
		]);

		$this->assertEquals($category2->slug, $category1->slug.'-1', 'The slug should have an incremental number');
	}

	/** @test */
	public function itShouldNotUpdateSlug()
	{
		$category = factory(Category::class)->create([
			'name' => 'this is a test'
		]);

		$category->name = $category->name;
		$category->save();

		$this->assertEquals('this-is-a-test', $category->slug, 'It should the same even though the record is being updated');
	}

	/** @test */
	public function itShouldUpdateTheSlug()
	{
		$category = factory(Category::class)->create();

		$category->name = 'This is a test';
		$category->save();

		$this->assertEquals('this-is-a-test', $category->slug, 'It should update the slug on name change');
	}
}