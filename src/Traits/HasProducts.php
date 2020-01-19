<?php

namespace Ronmrcdo\Inventory\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasProducts
{
	/**
	 * Relation on the product
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany $this
	 */
	public function products(): HasMany
	{
		return $this->hasMany('Ronmrcdo\Inventory\Models\Product');
	}
}