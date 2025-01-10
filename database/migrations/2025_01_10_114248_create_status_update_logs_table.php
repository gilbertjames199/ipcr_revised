<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusUpdateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_update_logs', function (Blueprint $table) {
            $table->id();
            $table->string('emp_cats')->nullable();
            $table->string('requested_by_cats')->nullable();
            $table->text('reset_by_cats')->nullable();
            $table->text('ipaddress')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('status_update_logs');
    }
}
