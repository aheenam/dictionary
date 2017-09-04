<?php
/** @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Aheenam\Dictionary\Models\Word::class, function (Faker\Generator $faker) {
	return [
		'key' => $faker->word,
		'info' => json_encode([]),
		'is_verified' => $faker->boolean
	];
});

$factory->define(Aheenam\Dictionary\Models\Translation::class, function (Faker\Generator $faker) {
	return [
		'key' => $faker->word,
		'language' => $faker->languageCode,
		'is_verified' => $faker->boolean
	];
});