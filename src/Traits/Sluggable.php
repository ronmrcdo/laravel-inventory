<?php

namespace Ronmrcdo\Inventory\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait Sluggable
{
	/**
	 * Generate a slug on the model on boot
	 * 
	 * @return void
	 */
	protected static function bootSluggable(): void
	{
		static::creating(function (Model $model) {
            $model->createUniqueSlug();
        });

        static::updating(function (Model $model) {
            $model->createUniqueSlug();
        });
	}

	protected function createUniqueSlug(): void
	{
		$this->slug = $this->generateUniqueSlug();
	}

	/**
	 * Generate the unique string slug from the $sluggable property
	 * in the model
	 * 
	 * @return string
	 */
	protected function generateUniqueSlug(): string
	{
		$slug = Str::slug($this->attributes[$this->sluggable]);
		$i = 1;

		while($this->isSlugExists($slug) || $slug === '') {
			$slug = $slug.'-'.$i++;
		}
		
		return $slug;
	}

	/**
	 * Assert if the slug exists
	 * 
	 * @return bool
	 */
	protected function isSlugExists(string $slug): bool
	{
		$key = $this->getKey();

		if ($this->incrementing) {
			$key ?? '0';
		}

		$query = static::where('slug', $slug)
				->where($this->getKeyName(), '!=', $key)
				->withoutGlobalScopes();

		return $query->exists();
	}
}