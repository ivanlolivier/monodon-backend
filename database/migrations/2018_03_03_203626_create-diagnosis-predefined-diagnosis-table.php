<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosisPredefinedDiagnosisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis_predefined_diagnosis', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('diagnosis_id');
            $table->unsignedInteger('predefined_diagnosis_id');

            $table->foreign('diagnosis_id')->references('id')->on('diagnosis');
            $table->foreign('predefined_diagnosis_id')->references('id')->on('predefined_diagnosis');

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
        Schema::drop('diagnosis_predefined_diagnosis');
    }
}
