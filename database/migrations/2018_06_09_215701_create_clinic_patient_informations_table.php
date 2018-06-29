<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicPatientInformationsTable extends Migration
{
    public function up()
    {
        Schema::create('clinic_patient_informations', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');

            $table->unsignedInteger('clinic_id');
            $table->foreign('clinic_id')->references('id')->on('clinics');

            $table->string('name');
            $table->string('surname');
            $table->enum('document_type', ['passport', 'identity_document', 'driver_license']);
            $table->string('document');
            $table->date('birthdate');
            $table->enum('sex', ['male', 'female']);
            $table->string('phones');
            $table->string('email');
            $table->string('photo')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('clinic_patient_informations');
    }
}
