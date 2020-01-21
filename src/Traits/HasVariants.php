<?php

namespace Ronmrcdo\Inventory\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ronmrcdo\Inventory\Exceptions\InvalidVariantException;
use Ronmrcdo\Inventory\Exceptions\InvalidAttributeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait HasVariants
{
	/**
	 * Add Variant to the product
	 * 
	 * $variant = array(
	 *  'sku' => string,
	 *  'options' => string, <-- Attribute name
	 *  'value' => string, <-- Attribute value
	 * )
	 * @param array $variant
	 */
	public function addVariant($variant)
	{
		DB::beginTransaction();

		try {
			// Create the sku first
			$sku = $this->skus()->create(['code' => $variant['sku']]);
			$attribute = $this->attributes()->where('name', $variant['options'])->firstOrFail();
			$value = $attribute->values()->where('value', $variant['value'])->firstOrFail();

			$this->variations()->create([
				'product_sku_id' => $sku->id,
				'product_attribute_id' => $attribute->id,
				'product_attribute_value_id' => $value->id
			]);
			
			DB::commit();
		} catch (ModelNotFoundException $err) { // 
			DB::rollBack();

			throw new InvalidAttributeException('Invalid Attribute/Value', 404);
		
		} catch (\Throwable $err) {
			DB::rollBack();

			throw new InvalidVariantException("Invalid Product Variant data given", 400);
		}

		return $this;
	}

	/**
	 * Static function that automatically query for the sku
	 * 
	 * @param string $sku
	 * @return \Ronmrcdo\Inventory\Models\Product
	 */
	public static function findBySku(string $sku)
	{
		return static::whereHas('skus', function ($q) use ($sku) {
			$q->where('code', $sku);
		})->firstOrFail();
	}

	/**
	 * Scope for Find Product by sku
	 * 
	 * @param \Illuminate\Database\Eloquent\Builder  $query
	 * @param string $sku
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeWhereSku(Builder $query, string $sku): Builder
	{
		return $query->whereHas('skus', function ($q) use ($sku) {
			$q->where('code', $sku);
		});
	}

	/**
	 * Product sku relation
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany;
	 */
	public function skus(): HasMany
	{
		return $this->hasMany('Ronmrcdo\Inventory\Models\ProductSku');
	}

	/**
	 * Product Variations
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany;
	 */
	public function variations(): HasMany
	{
		return $this->hasMany('Ronmrcdo\Inventory\Models\ProductVariant');
	}
}