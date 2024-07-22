<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToIpcrSemestralsTableActual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr__semestrals', function (Blueprint $table) {
            $table->string('pg_dept_head')->after('status_accomplishment')->nullable();
            $table->string('division_name')->after('status_accomplishment')->nullable();
            $table->string('department')->after('status_accomplishment')->nullable();
            $table->string('department_code')->after('status_accomplishment')->nullable();
            $table->string('employment_type')->after('position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ipcr__semestrals', function (Blueprint $table) {
            //
        });
    }
}
