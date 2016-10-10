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
        factory(Clinic::class, 10)->create()->each(function (Clinic $clinic) {

            for ($i = 0; $i <= random_int(2, 7); $i++) {
                $dentist = factory(Dentist::class)->make();

                $clinic->dentists()->save($dentist);

                $dentist->auth()->save(new User([
                    "email"    => $dentist->email,
                    "password" => 'secret',
                ]));
            }

            for ($i = 0; $i <= random_int(8, 15); $i++) {
                $patient = factory(Patient::class)->make();
                $clinic->patients()->save($patient);

                $patient->auth()->save(new User([
                    "email"    => $patient->email,
                    "password" => 'secret',
                ]));
            }

            for ($i = 0; $i <= random_int(3, 10); $i++) {
                $employee = factory(Employee::class)->make();
                $clinic->employees()->save($employee);

                $employee->auth()->save(new User([
                    "email"    => $employee->email,
                    "password" => 'secret',
                ]));
            }

        });
    }
}
