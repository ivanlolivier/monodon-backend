<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('dentist_id');
            $table->unsignedInteger('clinic_id');

            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('dentist_id')->references('id')->on('dentists');
            $table->foreign('clinic_id')->references('id')->on('clinics');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('visits');
    }
}
