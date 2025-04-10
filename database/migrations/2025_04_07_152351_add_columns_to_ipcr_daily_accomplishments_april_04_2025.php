<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToIpcrDailyAccomplishmentsApril042025 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr_daily_accomplishments', function (Blueprint $table) {
            $table->string('idHIPCR')->nullable()->after('individual_final_output_id');
            $table->string('idHSPCR')->nullable()->after('idDPCR');
            $table->string('idHDPCR')->nullable()->after('idDPCR');
            $table->string('idHPCR')->nullable()->after('idDPCR');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ipcr_daily_accomplishments', function (Blueprint $table) {
            //
        });
    }
}
