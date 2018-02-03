<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('patient_subscriptions', function (Blueprint $table) {
            $table->unsignedInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients');

            $table->unsignedInteger('notification_topic_id');
            $table->foreign('notification_topic_id')->references('id')->on('notification_topics');

            $table->boolean('subscribed');

            $table->primary(['patient_id', 'notification_topic_id']);
            $table->timestamps();
        });


    }

    public function down()
    {
        Schema::dropIfExists('patient_subscriptions');
    }
}
