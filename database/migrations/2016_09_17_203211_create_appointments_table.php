<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('clinic_id');
            $table->unsignedInteger('dentist_id');
            $table->unsignedInteger('patient_id');
            $table->dateTime('datetime');

            $table->string('title');
            $table->text('description');

            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('dentist_id')->references('id')->on('dentists');
            $table->foreign('patient_id')->references('id')->on('patients');

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
        Schema::drop('appointments');
    }
}
