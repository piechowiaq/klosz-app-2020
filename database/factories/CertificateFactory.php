<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Certificate;
use App\Training;
use App\Company;
use Faker\Generator as Faker;

$factory->define(Certificate::class, function (Faker $faker) {
    $training = factory(Training::class)->create()->pluck('id')->toArray();
    $company = factory(Company::class)->create()->pluck('id')->toArray();
    return [
        'training_id' => $faker->randomElement($training),
        'company_id' => $faker->randomElement($company),

    ];
});
