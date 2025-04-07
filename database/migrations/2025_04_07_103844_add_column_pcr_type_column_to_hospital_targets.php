<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPcrTypeColumnToHospitalTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hospital_targets', function (Blueprint $table) {
            $table->string('pcr_type')->after('slug')->nullable()->default('hipcr')->comment('hipcr -ipcr hospital,ipcr -ipcr capitol, hspcr -hospital section, hpcr, hdpcr -hospital dpcr,dpcr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospital_targets', function (Blueprint $table) {
            //
        });
    }
}
