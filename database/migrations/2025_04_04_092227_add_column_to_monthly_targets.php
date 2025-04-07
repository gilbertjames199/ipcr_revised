<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMonthlyTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_targets', function (Blueprint $table) {
            $table->string('is_hospital')->default('0')->comment('Identify if hospital target(1) or not(0)')->after('dpcr_target_id');
            $table->string('idHPCR')->nullable()->comment('Points to hospital outputs table')->after('dpcr_target_id');
            $table->string('idHDPCR')->nullable()->comment('Points to hospital division outputs table')->after('dpcr_target_id');
            $table->string('idHSPCR')->nullable()->comment('Points to hospital section outputs table')->after('dpcr_target_id');
            $table->string('idHIPCR')->nullable()->comment('Points to hospital individual outputs table')->after('dpcr_target_id');
            $table->string('hospital_target_id')->nullable()->comment('Points to hospital targets table')->after('dpcr_target_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_targets', function (Blueprint $table) {
            //
        });
    }
}
