<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBuccalZoneToTreatmentsAssignedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('treatments_assigned', function (Blueprint $table) {
            $table->unsignedInteger('buccal_zone_id');
            $table->foreign('buccal_zone_id')->references('id')->on('buccal_zones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('treatments_assigned', function (Blueprint $table) {
            $table->dropForeign('buccal_zone_id');
            $table->dropColumn('buccal_zone_id');
        });
    }
}
