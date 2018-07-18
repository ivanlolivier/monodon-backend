<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixUniqueIndexInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('authenticatable_type');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->unique(['email', 'authenticatable_type'], 'unique_email_by_type');
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('unique_email_by_type');
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->unique('email', 'authenticatable_type');
        });
    }
}
