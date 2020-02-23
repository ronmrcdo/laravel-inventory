<?php

namespace Ronmrcdo\Inventory\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCategories
{
	/**
	 * Relation on the Product
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo $this
	 */
	public function category(): BelongsTo
	{
		return $this->belongsTo(config('laravel-inventory.category'));
	}
}