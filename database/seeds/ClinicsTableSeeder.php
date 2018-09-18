<?php

use App\Models\Auth\User;
use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Employee;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class ClinicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clinic = factory(Clinic::class)->create();

        for ($i = 1; $i <= 70; $i++) {
            $dentist = factory(Dentist::class)->make(['email' => 'dentist' . $i . '@mailinator.com']);
            $clinic->dentists()->save($dentist);

            $dentist->auth()->save(new User([
                "email"    => $dentist->email,
                "password" => 'secret',
            ]));
        }

        for ($i = 1; $i <= 70; $i++) {
            $patient = factory(Patient::class)->make(['email' => 'patient' . $i . '@mailinator.com']);
            $clinic->patients()->save($patient);

            $patient->auth()->save(new User([
                "email"    => $patient->email,
                "password" => 'secret',
            ]));
        }

        for ($i = 1; $i <= 70; $i++) {
            $employee = factory(Employee::class)->make(['email' => 'assistant' . $i . '@mailinator.com']);
            $clinic->employees()->save($employee);

            $employee->auth()->save(new User([
                "email"    => $employee->email,
                "password" => 'secret',
            ]));
        }
    }
}
