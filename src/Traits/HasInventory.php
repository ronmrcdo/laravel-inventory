<?php

namespace Ronmrcdo\Inventory\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

trait HasInventory
{
	/**
	 * Get the list of warehouse in which product
	 * has stocks
	 * 
	 * @return \Illuminate\Support\Collection
	 */
	public function getWarehouses(): Collection
	{
		return collect($this->warehouses)
						->map(function ($item) {
							return $item->warehouse;
						})
						->unique('id')
						->values();
	}

	/**
	 * Relation to get the stocks in inventory
	 * 
	 * @param \Illuminate\Database\Eloquent\Relations\HasManyThrough
	 */
	public function warehouses(): HasManyThrough
	{
		return $this->hasManyThrough('Ronmrcdo\Inventory\Models\InventoryStock', 'Ronmrcdo\Inventory\Models\ProductSku')->with('warehouse');
	}
}