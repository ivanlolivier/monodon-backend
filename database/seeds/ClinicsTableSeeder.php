<?php

use App\Model\Clinic;
use App\Model\Dentist;
use App\Model\Employee;
use App\Model\Patient;
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
                $clinic->dentists()->save(factory(Dentist::class)->make());
            }

            for ($i = 0; $i <= random_int(8, 15); $i++) {
                $clinic->patients()->save(factory(Patient::class)->make());
            }

            for ($i = 0; $i <= random_int(3, 10); $i++) {
                $clinic->employees()->save(factory(Employee::class)->make());
            }

        });
    }
}
