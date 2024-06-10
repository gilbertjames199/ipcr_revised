<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_change_logs', function (Blueprint $table) {
            $table->id();
            $table->string('employee_cats');
            $table->string('acted_by')->comment('CATS number of employee who reset the password');
            $table->string('previous')->comment('Previous encrypted password');
            $table->string('current')->comment('Current encrypted password');
            $table->string('requested_by')->comment('Name of the individual/s who requested for password reset');
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
        Schema::dropIfExists('change_logs');
    }
}
