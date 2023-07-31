<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToIpcrTargetsType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('i_p_c_r_targets', function (Blueprint $table) {
            $table->string('ipcr_type')->after('semester');
            $table->string('ipcr_semester_id')->after('ipcr_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('i_p_c_r_targets', function (Blueprint $table) {
            //
        });
    }
}
