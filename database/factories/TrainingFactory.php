<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Training;
use Faker\Generator as Faker;

$factory->define(Training::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->name,
        'valid_for' => $faker->numberBetween(0,24),
    ];
});
