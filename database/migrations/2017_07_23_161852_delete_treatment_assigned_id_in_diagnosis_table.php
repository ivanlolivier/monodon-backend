<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteTreatmentAssignedIdInDiagnosisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diagnosis', function (Blueprint $table) {
            $table->dropForeign('diagnosis_treatment_assigned_id_foreign');
            $table->dropColumn('treatment_assigned_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diagnosis', function (Blueprint $table) {
            $table->unsignedInteger('treatment_assigned_id');
            $table->foreign('treatment_assigned_id')->references('id')->on('treatments_assigned');
        });
    }
}
