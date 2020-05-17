<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {

    return [
        'name' => $faker->firstName,
        'number' => $faker->numberBetween(0,500),
        'surname' => $faker->lastName,
        'company_id' => factory(Company::class)->create(),
    ];
});
