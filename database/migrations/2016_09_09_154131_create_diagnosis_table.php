<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->unsignedInteger('derivation_id')->nullable();
            $table->enum('type', ['healthy', 'moreInfo', 'onTreatment', 'derivated']);

            $table->timestamps();

            //References
            $table->foreign('derivation_id')->references('id')->on('derivations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnosis');
    }
}
