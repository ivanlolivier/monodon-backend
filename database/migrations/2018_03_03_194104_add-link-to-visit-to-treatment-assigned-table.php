<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLinkToVisitToTreatmentAssignedTable extends Migration
{
    public function up()
    {
        Schema::table('treatments_assigned', function (Blueprint $table) {
            $table->dropForeign('treatments_assigned_diagnosis_id_foreign');
            $table->dropColumn('diagnosis_id');

            $table->unsignedInteger('visit_id')->nullable()->after('id');
            $table->foreign('visit_id')->references('id')->on('visits');
        });
    }

    public function down()
    {
        Schema::table('treatments_assigned', function (Blueprint $table) {
            $table->dropForeign('treatments_assigned_visit_id_foreign');
            $table->dropColumn('visit_id');

            $table->unsignedInteger('diagnosis_id')->nullable()->after('id');
            $table->foreign('diagnosis_id')->references('id')->on('diagnosis');
        });
    }
}
