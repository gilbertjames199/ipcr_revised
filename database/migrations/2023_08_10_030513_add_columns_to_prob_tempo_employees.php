<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProbTempoEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prob_tempo_employees', function (Blueprint $table) {
            $table->string('rating_period_from_2')->after('rating_period_to')->nullable();
            $table->string('rating_period_to_2')->after('rating_period_from_2')->nullable();
            $table->string('rating_period_from_3')->after('rating_period_to_2')->nullable();
            $table->string('rating_period_to_3')->after('rating_period_from_3')->nullable();
            $table->string('rating_period_from_4')->after('rating_period_to_3')->nullable();
            $table->string('rating_period_to_4')->after('rating_period_from_4')->nullable();
            $table->string('rating_period_from_5')->after('rating_period_to_4')->nullable();
            $table->string('rating_period_to_5')->after('rating_period_from_5')->nullable();
            $table->string('rating_period_from_6')->after('rating_period_to_5')->nullable();
            $table->string('rating_period_to_6')->after('rating_period_from_6')->nullable();
            $table->string('rating_period_from_7')->after('rating_period_to_6')->nullable();
            $table->string('rating_period_to_7')->after('rating_period_from_7')->nullable();
            $table->string('rating_period_from_8')->after('rating_period_to_7')->nullable();
            $table->string('rating_period_to_8')->after('rating_period_from_8')->nullable();
            $table->string('rating_period_from_9')->after('rating_period_to_8')->nullable();
            $table->string('rating_period_to_9')->after('rating_period_from_9')->nullable();
            $table->string('rating_period_from_10')->after('rating_period_to_9')->nullable();
            $table->string('rating_period_to_10')->after('rating_period_from_10')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prob_tempo_employees', function (Blueprint $table) {
            //
        });
    }
}
