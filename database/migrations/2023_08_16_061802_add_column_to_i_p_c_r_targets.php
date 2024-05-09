<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToIPCRTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('i_p_c_r_targets', function (Blueprint $table) {
            $table->string('is_additional_target')->nullable()->after('ipcr_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('i_p_c_r_targets', function (Blueprint $table) {
            //
        });
    }
}
