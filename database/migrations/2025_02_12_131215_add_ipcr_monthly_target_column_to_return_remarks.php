<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpcrMonthlyTargetColumnToReturnRemarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('return_remarks', function (Blueprint $table) {
            $table->string('ipcr_monthly_target_id')->nullable()->after('ipcr_semestral_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('return_remarks', function (Blueprint $table) {
            //
        });
    }
}
