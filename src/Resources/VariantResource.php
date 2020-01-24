<?php

namespace Ronmrcdo\Inventory\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'parent_product_id' => $this->product_id,
			'sku' => $this->code,
			'name' => $this->product->name,
			'short_description' => $this->product->short_description,
			'description' => $this->product->description,
			'price' => $this->price,
			'cost' => $this->cost,
			'category' => [
				'id' => $this->product->category_id,
				'name' => $this->product->category->name
			],
			'attributes' => collect($this->variant)->map(function ($item) {
				return [
					'name' => $item->attribute->name,
					'option' => $item->option->value
				];
			})->values()->toArray()
		];
	}
}