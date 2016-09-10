<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicsDentistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinics_dentists', function (Blueprint $table) {
            $table->increments('id');

            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('dentist_id')->references('id')->on('dentists');

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
        Schema::drop('clinics_dentists');
    }
}
