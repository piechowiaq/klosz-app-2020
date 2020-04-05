<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Registry;
use Faker\Generator as Faker;

$factory->define(Registry::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
        'valid_for' => $faker->numberBetween(0,24)
    ];
});
