<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_remarks', function (Blueprint $table) {
            $table->id();
            $table->Integer("idSemestral");
            $table->Integer("target_output_id");
            $table->Integer("month");
            $table->Integer("year");
            $table->text("remarks");
            $table->text("target_output_type");
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
        Schema::dropIfExists('monthly_remarks');
    }
}
