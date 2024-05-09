<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_remarks', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('regular/probationary');
            $table->string('remarks');
            $table->string('ipcr_semestral_id')->comment('if type=regular, then id refers to ipcr_semestrals table; else, id refers to probationary_temporary_employees');
            $table->string('employee_code')->comment('indicate the employee_code of the immediate/next higher supervisor who returned the ipcr');
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
        Schema::dropIfExists('return_remarks');
    }
}
