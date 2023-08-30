<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToIpcrProbTempoTargetsNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr_prob_tempo_targets', function (Blueprint $table) {
            //$table->string('ipcr_type')->after('ipcr_code')->comment('specifiy if core or support');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ipcr_prob_tempo_targets', function (Blueprint $table) {
            //
        });
    }
}
