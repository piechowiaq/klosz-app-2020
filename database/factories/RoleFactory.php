<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;

use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {

    return [
        'name' => $faker->unique()->randomElement(['Admin' ,'Manager', 'User']),
        'description' => $faker->sentence(4),
    ];
});
