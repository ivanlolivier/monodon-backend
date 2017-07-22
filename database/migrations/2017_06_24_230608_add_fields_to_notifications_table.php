<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->time('time_to_send')->default('21:00');
            $table->enum('type', ['single', 'daily', 'weekly', 'monthly'])->default('single');
            $table->date('start_sending')->default('2017-08-01');
            $table->date('finish_sending')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('finish_sending');
            $table->dropColumn('start_sending');
            $table->dropColumn('type');
            $table->dropColumn('time_to_send');
        });
    }
}
