<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotificationIdInNotificationPeriodicitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notification_periodicities', function (Blueprint $table) {
            $table->unsignedInteger('notification_id')->after('id');
            $table->foreign('notification_id')->references('id')->on('notifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notification_periodicities', function (Blueprint $table) {
            $table->dropForeign('notification_periodicities_notification_id_foreign');
            $table->dropColumn('notification_id');
        });
    }
}
