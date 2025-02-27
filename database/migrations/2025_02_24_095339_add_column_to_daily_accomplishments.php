<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToDailyAccomplishments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr_daily_accomplishments', function (Blueprint $table) {
            $table->string('type')->comment('ipcr, dpcr, hpcr, or spcr')->after('emp_code');
            $table->string('idDPCR')->nullable()->after('individual_final_output_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_accomplishments', function (Blueprint $table) {
            //
        });
    }
}
