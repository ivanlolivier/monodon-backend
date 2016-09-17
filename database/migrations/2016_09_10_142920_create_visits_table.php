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
            $table->unsignedInteger('diagnostic_id')->nullable();
            $table->unsignedInteger('treatment_id')->nullable();
            $table->unsignedInteger('parent_visit_id')->nullable();

            $table->enum('type', ['new_reason', 'follow_up_treatment', 'follow_up_diagnostic']);

            //References
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('dentist_id')->references('id')->on('dentists');
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('diagnostic_id')->references('id')->on('diagnostics');
            $table->foreign('treatment_id')->references('id')->on('treatments');
            $table->foreign('parent_visit_id')->references('id')->on('visits');

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
