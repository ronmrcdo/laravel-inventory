<?php

namespace Ronmrcdo\Inventory\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'options' => collect($this->values)->map(function ($item) {
				return $item->value;
			})->values()->toArray()
		];
	}
}