<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsDailyAccomplishment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr_daily_accomplishments', function (Blueprint $table) {
            $table->Integer('quality')->nullable()->after('quantity');
            $table->text('timeliness')->nullable()->after('quantity');
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
