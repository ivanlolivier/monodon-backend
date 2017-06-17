<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPatientIdToTreatmentsAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('treatments_assigned', function (Blueprint $table) {
            $table->unsignedInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('treatments_assigned', function (Blueprint $table) {
            $table->dropIndex('treatments_assigned_patient_id_foreign');
            $table->dropColumn('patient_id');
        });
    }
}
