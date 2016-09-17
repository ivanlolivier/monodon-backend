<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeVisitInterrogationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_interrogation', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('question_id');
            $table->unsignedInteger('visit_id');

            $table->boolean('answer');

            $table->foreign('question_id')->references('id')->on('questions');
            $table->foreign('visit_id')->references('id')->on('visits');

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
        Schema::drop('visit_interrogation');
    }
}
