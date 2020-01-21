<?php

namespace Ronmrcdo\Inventory\Tests\Unit;

use Illuminate\Support\Str;
use Ronmrcdo\Inventory\Models\Product;
use Ronmrcdo\Inventory\Models\Attribute;
use Ronmrcdo\Inventory\Models\AttributeValue;
use Ronmrcdo\Inventory\Models\ProductSku;
use Ronmrcdo\Inventory\Models\ProductVariant;
use Ronmrcdo\Inventory\Adapters\ProductAdapter;
use Ronmrcdo\Inventory\Exceptions\InvalidVariantException;
use Ronmrcdo\Inventory\Tests\TestCase;

class ProductVariationTest extends TestCase
{
	/** @test */
	public function itShouldHaveProductVariant()
	{
		// Parent Product
		$product = factory(Product::class)->create();

		$sizeAttr = factory(Attribute::class)->make([
			'name' => 'size'
		]);
		$sizeTerms = ['Small', 'Medium', 'Large'];
		$colorAttr = factory(Attribute::class)->make([
			'name' => 'color'
		]);
		$colorTerm = ['Black', 'White'];

		// Set the terms and attributes
		$product->addAttribute($sizeAttr->name);
		$product->addAttribute($colorAttr->name);
		$product->addAttributeTerm($sizeAttr->name, $sizeTerms);
		$product->addAttributeTerm($colorAttr->name, $colorTerm);
		
		$variantSmallBlack = [
			'sku' => 'WOOPROTSHIRT-SMBLK',
			'variation' => [
				['option' => 'color', 'value' => 'black'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$variantSmallWhite = [
			'sku' => 'WOOPROTSHIRT-SMWHT',
			'variation' => [
				['option' => 'color', 'value' => 'white'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$product->addVariant($variantSmallBlack);
		$product->addVariant($variantSmallWhite);

		$productResource = new ProductAdapter($product);
		$this->assertArrayHasKey('variations', $productResource->transform(), 'It should have an sku');
	}

	/** @test */
	public function itShouldCreateSingleProductWithSku()
	{
		$product = factory(Product::class)->create();

		// Add Sku for single product that has no variation
		$product->addSku(Str::random());

		$productResource = new ProductAdapter($product);
		$this->assertArrayHasKey('sku', $productResource->transform(), 'It should have an sku');
	}

	/** @test */
	public function itShouldThrowErrorDueToDuplicateAttribute()
	{
		$this->expectException(InvalidVariantException::class);

		// Parent Product
		$product = factory(Product::class)->create();

		$sizeAttr = factory(Attribute::class)->make([
			'name' => 'size'
		]);
		$sizeTerms = ['Small', 'Medium', 'Large'];
		$colorAttr = factory(Attribute::class)->make([
			'name' => 'color'
		]);
		$colorTerm = ['Black', 'White'];

		// Set the terms and attributes
		$product->addAttribute($sizeAttr->name);
		$product->addAttribute($colorAttr->name);
		$product->addAttributeTerm($sizeAttr->name, $sizeTerms);
		$product->addAttributeTerm($colorAttr->name, $colorTerm);
		
		$variantSmallBlack = [
			'sku' => 'WOOPROTSHIRT-SMBLK',
			'variation' => [
				['option' => 'color', 'value' => 'black'],
				['option' => 'color', 'value' => 'white'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$variantSmallWhite = [
			'sku' => 'WOOPROTSHIRT-SMWHT',
			'variation' => [
				['option' => 'color', 'value' => 'white'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$product->addVariant($variantSmallBlack);
		$product->addVariant($variantSmallWhite);
	}
}