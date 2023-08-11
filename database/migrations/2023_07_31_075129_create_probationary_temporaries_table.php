<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProbationaryTemporariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('probationary_temporaries', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code');
            $table->string('status');
            $table->string('rating_period');
            $table->string('month1_from')->nullable();
            $table->string('month1_to')->nullable();
            $table->string('month2_from')->nullable();
            $table->string('month2_to')->nullable();
            $table->string('month3_from')->nullable();
            $table->string('month3_to')->nullable();
            $table->string('month4_from')->nullable();
            $table->string('month4_to')->nullable();
            $table->string('month5_from')->nullable();
            $table->string('month5_to')->nullable();
            $table->string('month6_from')->nullable();
            $table->string('month6_to')->nullable();
            $table->string('month7_from')->nullable();
            $table->string('month7_to')->nullable();
            $table->string('month8_from')->nullable();
            $table->string('month8_to')->nullable();
            $table->string('month9_from')->nullable();
            $table->string('month9_to')->nullable();
            $table->string('month10_from')->nullable();
            $table->string('month10_to')->nullable();
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
        Schema::dropIfExists('probationary_temporaries');
    }
}
