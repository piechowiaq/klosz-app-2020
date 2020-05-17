<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\Position;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});
$factory->afterCreating(Company::class, function ($company, $faker) {
    $company->positions()->save(factory(Position::class)->make());
});
