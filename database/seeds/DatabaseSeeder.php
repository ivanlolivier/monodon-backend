<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmployeeTypesTableSeeder::class);
        $this->call(ClinicsTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
    }
}
