<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakePatientInterrogationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_interrogation', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('question_id');
            $table->unsignedInteger('patient_id');

            $table->boolean('answer');

            $table->foreign('question_id')->references('id')->on('questions');
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
        Schema::drop('patient_interrogation');
    }
}
