<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_targets', function (Blueprint $table) {
            $table->id();
            $table->string('ipcr_semestral_id');
            $table->string('idIPCR')->nullable()->comment('Points to individual final outputs table');
            $table->string('idDPCR')->nullable()->comment('Points to division outputs table');
            $table->string('idHIPCR')->nullable()->comment('Points to hospital individual outputs table');
            $table->string('idHSPCR')->nullable()->comment('Points to hospital section outputs table');
            $table->string('idHDPCR')->nullable()->comment('Points to hospital division outputs table');
            $table->string('idHPCR')->nullable()->comment('Points to hospital outputs table');
            $table->string('type');
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
        Schema::dropIfExists('hospital_targets');
    }
}
