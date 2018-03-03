<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeEnumInDiagnosisTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE diagnosis MODIFY type ENUM('TREATMENT','PREDEFINED','DERIVATION','HEALTHY','INCOMPLETE')");
        DB::statement("UPDATE diagnosis SET type = 'PREDEFINED' WHERE type = 'TREATMENT';");
        DB::statement("ALTER TABLE diagnosis MODIFY type ENUM('PREDEFINED','DERIVATION','HEALTHY','INCOMPLETE')");
    }

    public function down()
    {
        DB::statement("ALTER TABLE diagnosis MODIFY type ENUM('TREATMENT','PREDEFINED','DERIVATION','HEALTHY','INCOMPLETE')");
        DB::statement("UPDATE diagnosis SET type = 'TREATMENT' WHERE type = 'PREDEFINED';");
        DB::statement("ALTER TABLE diagnosis MODIFY type ENUM('TREATMENT','DERIVATION','HEALTHY','INCOMPLETE')");
    }
}
