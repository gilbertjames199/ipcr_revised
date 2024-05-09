<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsFromIpcrProbTempoTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr_prob_tempo_targets', function (Blueprint $table) {
            $table->dropColumn('month_1');
            $table->dropColumn('month_2');
            $table->dropColumn('month_3');
            $table->dropColumn('month_4');
            $table->dropColumn('month_5');
            $table->dropColumn('month_6');
            $table->dropColumn('month_7');
            $table->dropColumn('month_8');
            $table->dropColumn('month_9');
            $table->dropColumn('month_10');
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
