<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    $companies = factory(Company::class)->create()->pluck('id')->toArray();

    return [
        'name' => $faker->firstName,
        'number' => $faker->numberBetween(0,500),
        'surname' => $faker->lastName,
        'company_id' => $faker->randomElement($companies),
    ];
});
