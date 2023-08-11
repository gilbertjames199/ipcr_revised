<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProbTempoEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prob_tempo_employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code');
            $table->string('prob_status');
            $table->string('rating_period_from');
            $table->string('rating_period_to');
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
        Schema::dropIfExists('prob_tempo_employees');
    }
}
