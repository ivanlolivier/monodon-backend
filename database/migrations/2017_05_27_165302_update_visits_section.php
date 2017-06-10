<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateVisitsSection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropForeign('visits_treatment_id_foreign');
            $table->dropColumn('treatment_id');

            $table->dropForeign('visits_parent_visit_id_foreign');
            $table->dropColumn('parent_visit_id');

            $table->dropColumn('type');

            $table->unsignedInteger('progress_id')->nullable();
            $table->foreign('progress_id')->references('id')->on('progress');
        });

        Schema::table('diagnosis', function (Blueprint $table) {
            $table->unsignedInteger('parent_diagnosis_id')->nullable();
            $table->foreign('parent_diagnosis_id')->references('id')->on('diagnosis');

            $table->dropColumn('type');

            $table->unsignedInteger('derivation_id')->nullable();
            $table->foreign('derivation_id')->references('id')->on('derivations');

            $table->unsignedInteger('treatment_assigned_id')->nullable();
            $table->foreign('treatment_assigned_id')->references('id')->on('treatments_assigned');
        });

        Schema::table('diagnosis', function (Blueprint $table) {
            $table->enum('type', ['TREATMENT', 'DERIVATION', 'HEALTHY', 'INCOMPLETE']);
            $table->index('type');
        });

        Schema::table('treatments', function (Blueprint $table) {
            $table->dropForeign('treatments_diagnosis_id_foreign');
            $table->dropColumn('diagnosis_id');
        });

        Schema::table('derivations', function (Blueprint $table) {
            $table->dropForeign('derivations_diagnosis_id_foreign');
            $table->dropColumn('diagnosis_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->enum('type', ['new_reason', 'follow_up_treatment', 'follow_up_diagnosis']);
            $table->unsignedInteger('parent_visit_id')->nullable();
            $table->foreign('parent_visit_id')->references('id')->on('visits');
            $table->unsignedInteger('treatment_id')->nullable();
            $table->foreign('treatment_id')->references('id')->on('treatments');

            $table->dropForeign('progress_progress_id_foreign');
            $table->dropColumn('progress_id');
        });

        Schema::table('diagnosis', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('type');

            $table->dropForeign('diagnosis_parent_diagnosis_id_foreign');
            $table->dropForeign('derivations_derivation_id_foreign');
            $table->dropForeign('treatments_assigned_treatment_assigned_id_foreign');

            $table->dropColumn('parent_diagnosis_id');
            $table->dropColumn('derivation_id');
            $table->dropColumn('treatment_assigned_id');
        });

        Schema::table('treatments', function (Blueprint $table) {
            $table->unsignedInteger('diagnosis_id');
            $table->foreign('diagnosis_id')->references('id')->on('diagnosis');
        });

        Schema::table('derivations', function (Blueprint $table) {
            $table->unsignedInteger('diagnosis_id');
            $table->foreign('diagnosis_id')->references('id')->on('diagnosis');
        });
    }
}
