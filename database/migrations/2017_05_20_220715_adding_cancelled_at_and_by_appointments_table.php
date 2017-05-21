<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingCancelledAtAndByAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
//            $table->timestamp('cancelled_at')->nullable();
            $table->softDeletes();

            $table->morphs("deleted_by", 'deleted_by_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('deleted_by');

            $table->dropIndex('deleted_by_index');
            $table->dropColumn("deleted_by_type");
            $table->dropColumn("deleted_by_id");


        });
    }
}
