<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSemestralAccomplishmentRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('semestral_accomplishment_ratings', function (Blueprint $table) {
            $table->string('sem')->after('year')->nullable();
            $table->string('ipcr_sem_id')->after('sem')->nullable();
            $table->string('ave_core')->after('sem')->nullable();
            $table->string('ave_support')->after('ave_core')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('semestral_accomplishment_ratings', function (Blueprint $table) {
            //
        });
    }
}
