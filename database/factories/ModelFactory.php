<?php

use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Employee;
use App\Models\Patient;
use App\Models\Question;

$factory->define(Clinic::class, function (Faker\Generator $faker) {
    return [
        'name'    => $faker->company,
        'address' => $faker->address,
        'phones'  => $faker->phoneNumber,
    ];
});

$factory->define(Employee::class, function (Faker\Generator $faker) {
    return [
        'employee_type_id' => $faker->numberBetween(1, 2),
        'name'             => $faker->name,
        'email'            => $faker->email,
    ];
});

$factory->define(Patient::class, function (Faker\Generator $faker) {
    return [
        'name'          => $faker->firstName,
        'surname'       => $faker->lastName,
        'document_type' => $faker->randomElement(['passport', 'identity_document', 'driver_license']),
        'document'      => $faker->bankAccountNumber,
        'birthdate'     => $faker->date(),
        'sex'           => $faker->randomElement(['male', 'female']),
        'photo'         => $faker->imageUrl(640, 480, 'people'),
        'phones'        => $faker->phoneNumber,
        'email'         => $faker->email,
        'tags'          => $faker->word,
    ];
});

$factory->define(Question::class, function (Faker\Generator $faker) {
    return [
        'question' => $faker->sentence . '?',
        'type'     => $faker->randomElement(['patient', 'visit']),
    ];
});

$factory->define(Dentist::class, function (Faker\Generator $faker) {
    return [
        'name'         => $faker->firstName,
        'surname'      => $faker->lastName,
        'affiliate_id' => $faker->uuid,
        'email'        => $faker->email,
        'phones'       => $faker->phoneNumber,
        'sex'          => $faker->randomElement(['male', 'female']),
    ];
});
