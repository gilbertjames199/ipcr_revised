<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemestralAccomplishmentRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semestral_accomplishment_ratings', function (Blueprint $table) {
            $table->id();
            $table->Integer("cats_number");
            $table->text("first_name");
            $table->text("last_name");
            $table->text("middle_name");
            $table->Double("numerical_rating");
            $table->text("adjectival_rating");
            $table->Integer("year");
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
        Schema::dropIfExists('semestral_accomplishment_ratings');
    }
}
