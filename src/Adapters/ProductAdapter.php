<?php

namespace Ronmrcdo\Inventory\Adapters;

use Ronmrcdo\Inventory\Resources\ProductResource;
use Ronmrcdo\Inventory\Adapters\BaseAdapter;

class ProductAdapter extends BaseAdapter
{
	/**
	 * Single resource transformer
	 * 
	 * @param mixed $model
	 */
	public function __construct($model)
	{
		parent::__construct(new ProductResource($model));
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
		$resource->setResource(ProductResource::collection($collection));

		return $resource->transform();
	}
}