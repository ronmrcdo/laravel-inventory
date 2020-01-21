<?php

namespace Ronmrcdo\Inventory\Contracts;

interface ResourceContract
{
	public function transform(): array;

	public function setResource($resource): void;

	public static function collection($collections): array;
}