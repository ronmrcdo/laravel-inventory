<?php

namespace Ronmrcdo\Inventory\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'sku' => $this->code,
			'attributes' => collect($this->variant)->map(function ($item) {
				return [
					'name' => $item->attribute->name,
					'option' => $item->option->value
				];
			})->values()->toArray()
		];
	}
}