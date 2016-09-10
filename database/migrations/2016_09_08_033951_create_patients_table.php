<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('surname');
            $table->enum('document_type', ['passport', 'identity_document', 'driver_license']);
            $table->string('document');

            $table->date('birthdate');
            $table->enum('sex', ['male', 'female']);
            $table->string('photo')->nullable();

            $table->string('phones');
            $table->string('email');

            $table->text('tags');

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
        Schema::drop('patients');
    }
}
