<?php

namespace Ronmrcdo\Inventory\Adapters;

use Ronmrcdo\Inventory\Resources\VariantResource;
use Ronmrcdo\Inventory\Adapters\BaseAdapter;

class ProductVariantAdapter extends BaseAdapter
{
	/**
	 * Single resource transformer
	 * 
	 * @param mixed $model
	 */
	public function __construct($model)
	{
		parent::__construct(new VariantResource($model));
	}

	/**
	 * Static function for the collection
	 * 
	 * @param \Illuminate\Database\Eloquent\Model $model
	 * @return array
	 */
	public static function collection($collection): array
	{
		$resource = new self($collection);
		$resource->setResource(VariantResource::collection($collection));

		return $resource->transform();
	}
}