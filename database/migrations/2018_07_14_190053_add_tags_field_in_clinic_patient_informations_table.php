<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTagsFieldInClinicPatientInformationsTable extends Migration
{
    public function up()
    {
        Schema::table('clinic_patient_informations', function (Blueprint $table) {
            $table->text('tags')->nullable();
        });
    }

    public function down()
    {
        Schema::table('clinic_patient_informations', function (Blueprint $table) {
            $table->dropColumn('tags');
        });
    }
}
