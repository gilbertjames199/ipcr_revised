<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleColumnDailyAccomplishment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr_daily_accomplishments', function (Blueprint $table) {
            //
            $table->string('emp_code')->after('idIPCR');
            $table->string('individual_output')->after('emp_code');
            $table->string('link')->after('emp_code');
            $table->string('remarks')->after('emp_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ipcr_daily_accomplishment', function (Blueprint $table) {
            //
        });
    }
}
