<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('progress', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('treatment_assigned_id');
            $table->foreign('treatment_assigned_id')->references('id')->on('treatments_assigned');

            $table->string('description');

            $table->unsignedInteger('parent_progress_id')->nullable();
            $table->foreign('parent_progress_id')->references('id')->on('progress');

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
        Schema::drop('progress');
    }
}
