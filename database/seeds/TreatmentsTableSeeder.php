<?php

use App\Models\Treatment;
use Illuminate\Database\Seeder;

class TreatmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Treatment::class, 50)->create();
    }
}
