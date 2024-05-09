<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProbationaryTemporaryEmployees121 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('probationary_temporary_employees', function (Blueprint $table) {
            $table->string('immediate_cats')->after('employee_code');
            $table->string('next_higher_cats')->after('immediate_cats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('probationary_temporary_employees', function (Blueprint $table) {
            //
        });
    }
}
