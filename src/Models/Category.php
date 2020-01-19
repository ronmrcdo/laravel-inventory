<?php

namespace Ronmrcdo\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Ronmrcdo\Inventory\Traits\Sluggable;
use Ronmrcdo\Inventory\Traits\HasProducts;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
	use Sluggable, HasProducts;
	
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
	 * @var string
	 */
	protected $sluggable = 'name';

	/**
	 * Assert if the Category is Parent
	 * 
	 * @return bool
	 */
	public function isParent(): bool
	{
		return is_null($this->parent_id);
	}

	/**
	 * Local scope for getting only the parents
	 * 
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeParentOnly($query)
	{
		return $query->whereNull('parent_id');
	}

	/**
	 * Sub children relationship
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany $this
	 */
	public function children(): HasMany
	{
		return $this->hasMany('Ronmrcdo\Inventory\Models\Category', 'parent_id', 'id');
	}

	/**
	 * Parent Relationship
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne $this
	 */
	public function parent(): HasOne
	{
		return $this->hasOne('Ronmrcdo\Inventory\Models\Category', 'id', 'parent_id');
	}
}