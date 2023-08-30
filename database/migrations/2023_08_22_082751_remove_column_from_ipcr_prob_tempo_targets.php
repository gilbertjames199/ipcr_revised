<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnFromIpcrProbTempoTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr_prob_tempo_targets', function (Blueprint $table) {
            $table->dropColumn('ipcr_pob_tempo_id');
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
