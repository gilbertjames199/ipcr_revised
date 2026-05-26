<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHalfIndicatorColumnToProbationaryTemporaryEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('probationary_temporary_employees', function (Blueprint $table) {
            $table->string('half_indicator')->nullable()->after('no_of_months');
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
            $table->dropColumn('half_indicator');
        });
    }
}
