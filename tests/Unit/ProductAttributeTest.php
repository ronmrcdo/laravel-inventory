<?php

namespace Ronmrcdo\Inventory\Tests\Unit;

use Ronmrcdo\Inventory\Models\Product;
use Ronmrcdo\Inventory\Models\Attribute;
use Ronmrcdo\Inventory\Models\AttributeValue;
use Ronmrcdo\Inventory\Exceptions\InvalidAttributeException;
use Ronmrcdo\Inventory\Tests\TestCase;

class ProductAttributeTest extends TestCase
{
	/** @test */
	public function itShouldAddAttributeToProduct()
	{
		$product = factory(Product::class)->create();
		
		$attribute = factory(Attribute::class)->make();

		$product->addAttribute($attribute['name']);

		$this->assertTrue($product->hasAttributes());
		$this->assertTrue($product->hasAttribute($attribute->name));
	}

	/** @test */
	public function itShouldAddAttributeAndValueToProduct()
	{
		$product = factory(Product::class)->create();
		$attribute = factory(Attribute::class)->create([
			'product_id' => $product->id
		]);

		$option = factory(AttributeValue::class)->make();

		$product->addAttributeTerm($attribute->name, $option->value);

		$this->assertTrue($attribute->values()->count() > 0);
	}

	/** @test */	
	public function itShouldGetProductAttributeAndValues()
	{
		$product = factory(Product::class)->create();
		$attribute = factory(Attribute::class)->create([
			'product_id' => $product->id
		]);
		$size = rand(2,5);

		$options = factory(AttributeValue::class, $size)->make();

		$options->each(function ($option) use ($product, $attribute) {
			$product->addAttributeTerm($attribute->name, $option->value);
		});

		$this->assertTrue(sizeof($product->loadAttributes()->first()->toArray()['values']) >= $size, 'It should attach all the options');
	}

	/** @test */
	public function itShouldCreateMultipleAttributes()
	{
		$product = factory(Product::class)->create();
		$size = rand(2,4);
		$attributes = factory(Attribute::class, $size)->make();

		$attributes->each(function($attribute) use ($product) {
			$product->addAttribute($attribute['name']);
		});

		$this->assertEquals($size, sizeof($product->loadAttributes()->toArray()), 'Attributes should be equal to product attribute');
	}

	/** @test */
	public function itShouldCreateMultipleAttributesUsingArray()
	{
		$product = factory(Product::class)->create();
		$size = rand(2,4);
		$attributes = factory(Attribute::class, $size)->make();

		$product->addAttributes($attributes->toArray());

		$this->assertEquals($size, sizeof($product->loadAttributes()->toArray()), 'Attributes should be equal to product attribute');
	}

	/** @test */
	public function itShouldThrowInvalidAttributeException()
	{
		$this->expectException(InvalidAttributeException::class);

		$product = factory(Product::class)->create();
		
		$product->addAttributeTerm('test', 'test');
	}
}