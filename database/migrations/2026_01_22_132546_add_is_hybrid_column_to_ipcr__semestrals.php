<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsHybridColumnToIpcrSemestrals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr__semestrals', function (Blueprint $table) {
            $table->string("is_hybrid")->after("pcr_type")->default("1")->comment("1- fetches hybrid values, 0 -strictly adheres to employee type");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ipcr__semestrals', function (Blueprint $table) {
            //
        });
    }
}
