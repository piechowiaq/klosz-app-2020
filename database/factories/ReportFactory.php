<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\Registry;
use App\Report;

use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(Report::class, function (Faker $faker) {

    return [
        'registry_id' => factory(Registry::class),
        'company_id' => factory(Company::class),
        'report_path' => UploadedFile::fake()->image('report.jpg'),
        'report_date' => $faker->date(),
        'expiry_date' => $faker->date(),
    ];
});


