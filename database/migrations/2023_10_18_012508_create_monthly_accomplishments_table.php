<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyAccomplishmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipcr_monthly_accomplishments', function (Blueprint $table) {
            $table->id();
            $table->string('month')->comment("month number");
            $table->string('year')->comment('Year number');
            $table->string('ipcr_semestral_id')->comment('ipcr semestral');
            $table->string('status')->comment('-1 ->returned, 0 ->submitted, 1 ->reviewed, 2 ->approved');
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
        Schema::dropIfExists('monthly_accomplishments');
    }
}
