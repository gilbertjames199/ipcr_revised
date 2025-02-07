<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyAccomplishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('IPCR_daily_accomplishments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('description');
            $table->string('emp_code');
            $table->integer('individual_final_output_id');
            $table->string('individual_output');
            $table->integer('sem_id');
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
        Schema::dropIfExists('daily__accomplishments');
    }
}
