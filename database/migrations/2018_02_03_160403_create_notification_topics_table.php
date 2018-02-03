<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTopicsTable extends Migration
{
    public function up()
    {
        Schema::create('notification_topics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->boolean('defaultSubscribed');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_topics');
    }
}
