<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProbTypeColumnToIpcrSemestrals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr__semestrals', function (Blueprint $table) {
            $table->string('prob_type')
                ->after('pcr_type')
                ->default('s')
                ->comment('
                    s -normal ipcr semestral (most common), not p or t;
                    p -probationary status;
                    t -temporary status
                ');
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
