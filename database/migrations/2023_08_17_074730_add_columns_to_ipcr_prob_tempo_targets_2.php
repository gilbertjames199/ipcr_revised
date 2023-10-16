<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToIpcrProbTempoTargets2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr_prob_tempo_targets', function (Blueprint $table) {
            $table->string('probationary_temporary_employees_id')->after('employee_code');
            $table->string('quantity')->after('ipcr_code');
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
