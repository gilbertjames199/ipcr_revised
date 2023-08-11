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
            $table->integer('quantity')->default(0);
            $table->integer('idIPCR')->comment('ID of IPCRCode');
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
