<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MovingRelationBetweenDiagnosisAndDerivationsToDerivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('derivations', function (Blueprint $table) {
            $table->unsignedInteger('diagnosis_id')->nullable();
            $table->foreign('diagnosis_id')->references('id')->on('diagnosis');
        });

        Schema::table('diagnosis', function (Blueprint $table) {
            $table->dropForeign('diagnosis_derivation_id_foreign');
            $table->dropColumn('derivation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('derivations', function (Blueprint $table) {
            $table->dropForeign('derivations_diagnosis_id_foreign');
            $table->dropColumn('diagnosis_id');
        });

        Schema::table('diagnosis', function (Blueprint $table) {
            $table->unsignedInteger('derivation_id')->nullable();
            $table->foreign('derivation_id')->references('id')->on('derivations');
        });
    }
}
