<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');

            $table->string('title');
            $table->text('message');
            
            $table->string('answer')->nullable();
            $table->enum('possible_answers', [
                'YES-NO',
                'OK',
                'RANGE'
            ]);

            $table->timestamp('send_at');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('answered_at')->nullable();

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
        Schema::drop('notifications');
    }
}
