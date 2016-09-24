<?php

use Illuminate\Database\Seeder;

class EmployeeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employee_types')->insert([
            'name'        => 'secretary',
            'description' => 'Person employed to assist with correspondence, keep records, make appointments, and carry out similar tasks.'
        ]);

        DB::table('employee_types')->insert([
            'name'        => 'administrator',
            'description' => 'Person responsible for running the business.'
        ]);
    }
}
