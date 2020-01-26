<?php

use Ronmrcdo\Inventory\Models\Warehouse;
use Faker\Generator as Faker;

$factory->define(Warehouse::class, function (Faker $faker) {
	return [
		'name' => $faker->word,
		'description' => $faker->words(3, true)
	];
});