<?php

use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Employee;
use App\Models\NotificationScheduled;
use App\Models\Patient;
use App\Models\Question;
use App\Models\Treatment;

$factory->define(Clinic::class, function (Faker\Generator $faker) {
    return [
        'name'    => $faker->company,
        'address' => $faker->address,
        'phones'  => isset($overwrite['phones']) ? $overwrite['phones'] : [$faker->phoneNumber],
    ];
});

$factory->define(Employee::class, function (Faker\Generator $faker, $overwrite) {
    return [
        'employee_type_id' => $faker->numberBetween(1, 2),
        'name'             => $faker->name,
        'email'            => isset($overwrite['email']) ? $overwrite['email'] : $faker->email,
    ];
});

$factory->define(Patient::class, function (Faker\Generator $faker, $overwrite) {
    return [
        'name'          => $faker->firstName,
        'surname'       => $faker->lastName,
        'document_type' => $faker->randomElement(['passport', 'identity_document', 'driver_license']),
        'document'      => $faker->bankAccountNumber,
        'birthdate'     => $faker->date(),
        'sex'           => $faker->randomElement(['male', 'female']),
        'photo'         => $faker->imageUrl(640, 480, 'people'),
        'phones'        => [$faker->phoneNumber],
        'email'         => isset($overwrite['email']) ? $overwrite['email'] : $faker->email,
        'tags'          => $faker->word,
    ];
});

$factory->define(Question::class, function (Faker\Generator $faker) {
    return [
        'question' => $faker->sentence . '?',
        'type'     => $faker->randomElement(['patient', 'visit']),
    ];
});

$factory->define(Dentist::class, function (Faker\Generator $faker, $overwrite) {
    return [
        'name'         => $faker->firstName,
        'surname'      => $faker->lastName,
        'affiliate_id' => $faker->uuid,
        'email'        => isset($overwrite['email']) ? $overwrite['email'] : $faker->email,
        'phones'       => [$faker->phoneNumber],
        'sex'          => $faker->randomElement(['male', 'female']),
    ];
});

$factory->define(NotificationScheduled::class, function (Faker\Generator $faker) {
    return [
        'patient_id'       => '1',
        'title'            => $faker->title,
        'message'          => $faker->sentence,
        'possible_answers' => $faker->randomElement(['YES-NO', 'OK', 'RANGE']),
    ];
});

$factory->define(Treatment::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'code' => $faker->numberBetween(),
    ];
});
