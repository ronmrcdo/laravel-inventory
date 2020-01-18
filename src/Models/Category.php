<?php

namespace Ronmrcdo\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Ronmrcdo\Inventory\Traits\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
	use Sluggable;
	
	/**
	 * Category Table
	 * 
	 * @var string
	 */
	protected $table = 'product_categories';

	/**
	 * Fields that are mass assignable
	 * 
	 * @var array
	 */
	protected $fillable = [
		'name', 'description', 'parent_id'
	];

	/**
	 * Sluggable attributes
	 * 
	 */
	protected $sluggable = 'name';

	/**
	 * Assert if the Category is Parent
	 */
	public function isParent(): bool
	{
		return is_null($this->parent_id);
	}

	/**
	 * Sub children relationship
	 * 
	 * @return HasMany
	 */
	public function children(): HasMany
	{
		return $this->hasMany('Ronmrcdo\Inventory\Models\Category');
	}

	/**
	 * Parent Relationship
	 * 
	 * @return HasOne
	 */
	public function parent(): HasOne
	{
		return $this->hasOne('Ronmrcdo\Inventory\Models\Category');
	}
}