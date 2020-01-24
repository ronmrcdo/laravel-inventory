<?php

namespace Ronmrcdo\Inventory\Tests\Unit;

use Illuminate\Support\Str;
use Ronmrcdo\Inventory\Models\Product;
use Ronmrcdo\Inventory\Models\Attribute;
use Ronmrcdo\Inventory\Adapters\ProductAdapter;
use Ronmrcdo\Inventory\Adapters\ProductVariantAdapter;
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
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'black'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$variantSmallWhite = [
			'sku' => 'WOOPROTSHIRT-SMWHT',
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'white'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$product->addVariant($variantSmallBlack);
		$product->addVariant($variantSmallWhite);

		$productResource = new ProductAdapter($product);

		$this->assertArrayHasKey('variations', $productResource->transform(), 'It should have a variation');
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
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'black'],
				['option' => 'color', 'value' => 'white'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$variantSmallWhite = [
			'sku' => 'WOOPROTSHIRT-SMWHT',
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'white'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$product->addVariant($variantSmallBlack);
		$product->addVariant($variantSmallWhite);
	}

	/** @test */
	public function itShouldThrowVariantExceptionForDuplicateVariantDifferentSku()
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
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'black'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$variantSmallWhite = [
			'sku' => 'WOOPROTSHIRT-SMWHT',
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'size', 'value' => 'small'],
				['option' => 'color', 'value' => 'white']
			]
		];

		$product->addVariant($variantSmallBlack);
		$product->addVariant($variantSmallWhite);

		$newVariant = [
			'sku' => 'WOOPROTSHIRT-SMNEW',
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'size', 'value' => 'small'],
				['option' => 'color', 'value' => 'black']
			]
		];

		// It should now throw due to same variation attributes of
		// WOOPROTSHIRT-SMNEW and WOOPROTSHIRT-SMBLK
		$product->addVariant($newVariant);
	}

	/** @test */
	public function itShouldFindProductBySku()
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
		$colorTerms = ['Black', 'White'];

		// Set the terms and attributes
		$product->addAttribute($sizeAttr->name);
		$product->addAttribute($colorAttr->name);
		$product->addAttributeTerm($sizeAttr->name, $sizeTerms);
		$product->addAttributeTerm($colorAttr->name, $colorTerms);
		
		$variantSmallBlack = [
			'sku' => 'WOOPROTSHIRT-SMBLK',
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'black'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$variantSmallWhite = [
			'sku' => 'WOOPROTSHIRT-SMWHT',
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'white'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$product->addVariant($variantSmallBlack);
		$product->addVariant($variantSmallWhite);

		$variantResource = new ProductVariantAdapter($product->findBySku('WOOPROTSHIRT-SMWHT'));
		
		$this->assertArrayHasKey('sku', $variantResource->transform(), 'It should have an sku');
	}

	/** @test */
	public function itShouldListTheVariations()
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
		$colorTerms = ['Black', 'White'];

		// Set the terms and attributes
		$product->addAttribute($sizeAttr->name);
		$product->addAttribute($colorAttr->name);
		$product->addAttributeTerm($sizeAttr->name, $sizeTerms);
		$product->addAttributeTerm($colorAttr->name, $colorTerms);
		
		$variantSmallBlack = [
			'sku' => 'WOOPROTSHIRT-SMBLK',
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'black'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$variantSmallWhite = [
			'sku' => 'WOOPROTSHIRT-SMWHT',
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'white'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$product->addVariant($variantSmallBlack);
		$product->addVariant($variantSmallWhite);

		$variantResource = new ProductVariantAdapter($product->findBySku('WOOPROTSHIRT-SMWHT'));
		
		$this->assertArrayHasKey('sku', $variantResource->transform(), 'It should have an sku');
		$this->assertArrayHasKey('parent_product_id', $variantResource->transform(), 'It should have a parent_product_id');
	}

	/** @test */
	public function itShouldListCollectionOfVariations()
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
		$colorTerms = ['Black', 'White'];

		// Set the terms and attributes
		$product->addAttribute($sizeAttr->name);
		$product->addAttribute($colorAttr->name);
		$product->addAttributeTerm($sizeAttr->name, $sizeTerms);
		$product->addAttributeTerm($colorAttr->name, $colorTerms);
		
		$variantSmallBlack = [
			'sku' => 'WOOPROTSHIRT-SMBLK',
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'black'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$variantSmallWhite = [
			'sku' => 'WOOPROTSHIRT-SMWHT',
			'price' => rand(100,300),
			'cost' => rand(50, 99),
			'variation' => [
				['option' => 'color', 'value' => 'white'],
				['option' => 'size', 'value' => 'small'],
			]
		];
		$product->addVariant($variantSmallBlack);
		$product->addVariant($variantSmallWhite);

		$variantResource = ProductVariantAdapter::collection($product->getVariations());
		
		$this->assertArrayHasKey('parent_product_id', head($variantResource), 'It should have a parent_product_id');
	}
}