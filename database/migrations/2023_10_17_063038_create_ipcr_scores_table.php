<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpcrScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipcr_scores', function (Blueprint $table) {
            $table->id();
            $table->string('IPCR_code');
            $table->integer('rating')->nullable();
            $table->string('adj_rating')->nullable();
            $table->string('efficiency')->nullable();
            $table->string('remarks_efficiency')->nullable();
            $table->integer('efficiency_max')->nullable();
            $table->integer('efficiency_min')->nullable();
            $table->string('effectiveness')->nullable();
            $table->string('remarks_effectiveness')->nullable();
            $table->string('timeliness')->nullable();
            $table->string('remarks_timeliness')->nullable();
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
        Schema::dropIfExists('ipcr_scores');
    }
}
