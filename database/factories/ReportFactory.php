<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\Registry;
use App\Report;

use Faker\Generator as Faker;

$factory->define(Report::class, function (Faker $faker) {
    $training = factory(Registry::class)->create()->pluck('id')->toArray();
    $company = factory(Company::class)->create()->pluck('id')->toArray();

    return [
        'registry_id' => $faker->randomElement($training),
        'company_id' => $faker->randomElement($company),
        'report_date' => $faker->date(),
        'expiry_date' => $faker->date(),

    ];
});
