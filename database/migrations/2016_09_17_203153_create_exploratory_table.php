<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExploratoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exploratory', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('visit_id');
            $table->foreign('visit_id')->references('id')->on('visits');

            $table->json('mouth_photo');

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
        Schema::drop('exploratory');
    }
}
