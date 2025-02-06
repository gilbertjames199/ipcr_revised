<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpcrTargetNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipcr_targets', function (Blueprint $table) {
            $table->id();
            $table->string('ipcr_semestral_id');
            $table->string('individual_final_output_id');
            $table->string('ipcr_type');
            $table->string('employee_code');
            $table->string('is_additional_target');
            $table->string('semester');
            $table->string('year');
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->string('slug')->unique();
            $table->softDeletes();
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
        Schema::dropIfExists('ipcr_target_news');
    }
}
