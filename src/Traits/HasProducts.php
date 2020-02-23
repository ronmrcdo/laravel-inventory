<?php

namespace Ronmrcdo\Inventory\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasProducts
{
	/**
	 * Assert if the Category has product based name or id
	 * 
	 * @param string|int $product
	 * @return bool
	 */
	public function hasProduct($product): bool
	{
		if (is_numeric($product)) {
			return $this->products()->where('id', $product)->exists();
		} elseif (is_string($product)) {
			return $this->products()->where('name', $product)->exists();
		}

		return false;
	}

	/**
	 * Assert if the Category has a product based on sku
	 * 
	 * @param string $sku
	 * @return bool
	 */
	public function hasProductBySku(string $sku): bool
	{
		return $this->products()->whereHas('skus', function ($q) use ($sku) {
			$q->where('code', $sku);
		})->exists();
	}

	/**
	 * Relation on the product
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany $this
	 */
	public function products(): HasMany
	{
		return $this->hasMany(config('laravel-inventory.product'));
	}
}