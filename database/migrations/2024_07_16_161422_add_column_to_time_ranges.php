<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToTimeRanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('time_ranges', function (Blueprint $table) {
            //
            $table->string('operator')->nullable()->after('equivalent_time_unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('time_ranges', function (Blueprint $table) {
            $table->dropColumn('operator');
        });
    }
}
