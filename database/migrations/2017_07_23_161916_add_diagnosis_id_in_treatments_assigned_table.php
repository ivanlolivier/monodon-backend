<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiagnosisIdInTreatmentsAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('treatments_assigned', function (Blueprint $table) {
            $table->unsignedInteger('diagnosis_id');
            $table->foreign('diagnosis_id')->references('id')->on('diagnosis');
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
            $table->dropForeign('diagnosis_id');
            $table->dropColumn('diagnosis_id');
        });
    }
}
