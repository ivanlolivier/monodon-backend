<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicsDentistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_dentist', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('clinic_id');
            $table->unsignedInteger('dentist_id');

            $table->timestamps();

            //References
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('dentist_id')->references('id')->on('dentists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clinic_dentist');
    }
}
