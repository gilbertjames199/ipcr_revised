<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyAccomplishmentRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_accomplishment_ratings', function (Blueprint $table) {
            $table->id();
            $table->Integer("cats_number");
            $table->text("first_name");
            $table->text("last_name");
            $table->text("middle_name");
            $table->Integer("month");
            $table->Double("numerical_rating");
            $table->text("adjectival_rating");
            $table->Integer("year");
            $table->string('sem');
            $table->string('ipcr_sem_id');
            $table->string('ave_core');
            $table->string('ave_support');
            $table->text("remarks");
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
        Schema::dropIfExists('monthly_accomplishment_ratings');
    }
}
