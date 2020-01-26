<?php

namespace Ronmrcdo\Inventory\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ronmrcdo\Inventory\Exceptions\InvalidAttributeException;

trait HasAttributes
{
	/**
	 * Create a product attribute
	 * 
	 * @param array $attributeData
	 * @throw  \Ronmrcdo\Inventory\Exceptions\InvalidAttributeException
	 * @return $this
	 */
	public function addAttribute(string $attribute)
	{
		DB::beginTransaction();

		try {
			$this->attributes()->create(['name' => $attribute]);

			DB::commit();
		} catch (\Throwable $err) { // No matter what error will occur we should throw invalidAttribute
			DB::rollBack();

			throw new InvalidAttributeException($err->getMessage(), 422);
		}

		return $this;
	}

	/**
	 * Create multiple attributes
	 * 
	 * @param mixed $attributes
	 * @throw  \Ronmrcdo\Inventory\Exceptions\InvalidAttributeException
	 * @return $this
	 */
	public function addAttributes($attributes)
	{
		DB::beginTransaction();

		try {
			$this->attributes()->createMany($attributes);

			DB::commit();
		} catch (\Throwable $err) { // No matter what error will occur we should throw invalidAttribute
			DB::rollBack();

			throw new InvalidAttributeException($err->getMessage(), 422);
		}

		return $this;
	}

	/**
	 * It should remove attribute from product
	 * 
	 * @param string $key
	 * @return self
	 */
	public function removeAttribute($attr)
	{
		DB::beginTransaction();

		try {
			$attribute = $this->attributes()->where('name', $attr)->firstOrFail();

			$attribute->delete();

			DB::commit();
		} catch (\Throwable $err) { // No matter what error will occur we should throw invalidAttribute
			DB::rollBack();

			throw new InvalidAttributeException($err->getMessage(), 422);
		}

		return $this;
	}

	/**
	 * It should remove attribute from product
	 * 
	 * @param string $key
	 * @return self
	 */
	public function removeAttributeTerm(string $attribute, string $term)
	{
		DB::beginTransaction();

		try {
			$attribute = $this->attributes()->where('name', $attribute)->firstOrFail();

			$attribute->removeValue($term);

			DB::commit();
		} catch (\Throwable $err) { // No matter what error will occur we should throw invalidAttribute
			DB::rollBack();

			throw new InvalidAttributeException($err->getMessage(), 422);
		}

		return $this;
	}

	/**
	 * Assert if the Product has attributes
	 * 
	 * @return bool
	 */
	public function hasAttributes(): bool
	{
		return !! $this->attributes()->count();
	}

	/**
	 * Assert if the product has this attributes
	 * 
	 * @param string|int $key
	 * 
	 * @return bool
	 */
	public function hasAttribute($key): bool
	{
		// If the arg is a numeric use the id else use the name
		if (is_numeric($key)) {
			return $this->attributes()->where('id', $key)->exists();
		} elseif (is_string($key)) {
			return $this->attributes()->where('name', $key)->exists();
		}

		return false;
	}

	/**
	 * Add Option Value on the attribute
	 * 
	 * @param string $option
	 * @param mixed $value
	 * 
	 * @throw \Ronmrcdo\Inventory\Exceptions\InvalidAttributeException
	 * 
	 * @return \Ronmrcdo\Inventory\Models\AttributeValue
	 */
	public function addAttributeTerm(string $option, $value)
	{
		$attribute = $this->attributes()->where('name', $option)->first();

		if (! $attribute) {
			throw new InvalidAttributeException("Invalid attribute", 422);
		}

		return $attribute->addValue($value);
	}

	/**
	 * Get Product Attributes
	 * 
	 * 
	 */
	public function loadAttributes()
	{
		return $this->attributes()->get()->load('values');
	}

	/**
	 * Relation on Attribute Model
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany $this
	 */
	public function attributes(): HasMany
	{
		return $this->hasMany('Ronmrcdo\Inventory\Models\Attribute');
	}
}