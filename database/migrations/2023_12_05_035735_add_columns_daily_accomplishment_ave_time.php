<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsDailyAccomplishmentAveTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr_daily_accomplishments', function (Blueprint $table) {
            $table->text('average_timeliness')->nullable()->after('timeliness');
            //
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
