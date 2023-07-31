<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToIPCRTargets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('i_p_c_r_targets', function (Blueprint $table) {
            $table->string("semester")->after('ipcr_code');
            $table->string("quantity_sem")->after('semester');
            $table->string("month_1")->after('quantity_sem');
            $table->string("month_2")->after('month_1');
            $table->string("month_3")->after('month_2');
            $table->string("month_4")->after('month_3');
            $table->string("month_5")->after('month_4');
            $table->string("month_6")->after('month_5');
            $table->string("year")->after("month_6");
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
