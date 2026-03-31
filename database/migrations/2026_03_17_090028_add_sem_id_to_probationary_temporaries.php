<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSemIdToProbationaryTemporaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('probationary_temporary_employees', function (Blueprint $table) {
            $table->string('sem_id')->comment('points to ipcr__semestrals table');
            $table->string('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('probationary_temporary_employees', function (Blueprint $table) {
            //
        });
    }
}
