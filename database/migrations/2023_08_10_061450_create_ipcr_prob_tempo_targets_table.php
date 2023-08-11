<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpcrProbTempoTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipcr_prob_tempo_targets', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code');
            $table->string('ipcr_pob_tempo_id');
            $table->string('ipcr_code');
            $table->string('target_quantity');
            $table->string('month_1');
            $table->string('month_2');
            $table->string('month_3');
            $table->string('month_4');
            $table->string('month_5');
            $table->string('month_6');
            $table->string('month_7');
            $table->string('month_8');
            $table->string('month_9');
            $table->string('month_10');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ipcr_prob_tempo_targets');
    }
}
