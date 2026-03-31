<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToIpcrSemestralsStatus1Status2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr__semestrals', function (Blueprint $table) {
            $table->string('period_1_status')->comment('Status of first period -applicable for probationary/temporar')->default('-1');
            $table->string('period_2_status')->comment('Status of second period -applicable for probationary/temporar')->default('-1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ipcr_semestrals_status_1_status_2', function (Blueprint $table) {
            //
        });
    }
}
