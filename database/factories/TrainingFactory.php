<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Position;
use App\Training;
use Faker\Generator as Faker;

$factory->define(Training::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->colorName,
        'valid_for' => $faker->numberBetween(0,24),
    ];
});

$factory->afterCreating(Training::class, function ($training, $faker) {
    $training->positions()->save(factory(Position::class)->make());
});
