<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Department;
use App\Position;
use Faker\Generator as Faker;

$factory->define(Position::class, function (Faker $faker) {
    $departments = factory(Department::class)->create()->pluck('id')->toArray();
    return [
        'department_id' => $faker->randomElement($departments),
        'name' => $faker->name,
    ];

});
