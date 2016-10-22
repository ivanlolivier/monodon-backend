<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientFcmTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_fcm_tokens', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedinteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');

            $table->string('fcm_token');

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
        Schema::drop('patient_fcm_tokens');
    }
}
