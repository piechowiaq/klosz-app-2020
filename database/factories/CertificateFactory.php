<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Certificate;
use App\Training;
use App\Company;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(Certificate::class, function (Faker $faker) {
//    $training = factory(Training::class)->create()->pluck('id')->toArray();
//    $company = factory(Company::class)->create()->pluck('id')->toArray();
    return [
        'training_id' => factory(Training::class)->create(),
        'company_id' => factory(Company::class)->create(),
        'certificate_path' => UploadedFile::fake()->image('report.jpg'),
        'training_date' => $faker->date(),
        'expiry_date' => $faker->date(),

    ];
});
