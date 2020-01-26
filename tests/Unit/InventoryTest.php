<?php

namespace Ronmrcdo\Inventory\Tests\Unit;

use Ronmrcdo\Inventory\Models\Product;
use Ronmrcdo\Inventory\Models\Attribute;
use Ronmrcdo\Inventory\Models\Warehouse;
use Ronmrcdo\Inventory\Adapters\ProductVariantAdapter;
use Ronmrcdo\Inventory\Tests\TestCase;

class InventoryTest extends TestCase
{
	/** @test */
	public function itShouldCreateWarehouse()
	{
		$warehouse = factory(Warehouse::class)->create();

		$this->assertDatabaseHas('warehouses', [
			'id' => $warehouse->id
		]);
	}

	/** @test */
	public function itShouldInsertProductInWarehouse()
	{
		$warehouse = factory(Warehouse::class)->create();

		$product = $this->createTestProduct();

		$product->skus->each(function ($sku) use ($warehouse) {
			$warehouse->items()->create([
				'product_sku_id' => $sku->id,
				'quantity' => rand(5, 20),
				'aisle' => 'ai-'. rand(20, 30),
				'row' => 'rw-'. rand(1, 9)
			]);
		});

		$warehouse->load('items');

		$this->assertArrayHasKey('items', $warehouse, 'Warehouse should have a stocks');
	}

	/** @test */
	public function itShouldListTheWarehouseStocks()
	{
		$warehouse = factory(Warehouse::class)->create();

		$product = $this->createTestProduct();

		$product->skus->each(function ($sku) use ($warehouse) {
			$warehouse->items()->create([
				'product_sku_id' => $sku->id,
				'quantity' => rand(5, 20),
				'aisle' => 'ai-'. rand(20, 30),
				'row' => 'rw-'. rand(1, 9)
			]);
		});

		$warehouse->load('items');
		$items = collect($warehouse->items)
					->map(function ($item) {
						return (new ProductVariantAdapter($item->product))->transform();
					})
					->toArray();

		// Each product should have a parent_product
		collect($items)->each(function ($item) {
			$this->assertArrayHasKey('parent_product_id', $item, 'It should have a parent_product_id');
		});
	}
}