<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailChangeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_change_logs', function (Blueprint $table) {
            $table->id();
            $table->string('prev_email')->nullable();
            $table->string('new_email')->nullable();
            $table->string('username')->nullable();
            $table->string('edited_by_cats')->nullable();
            $table->string('username_long')->nullable();
            $table->string('edited_by_name')->nullable();
            $table->string('host')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('email_change_logs');
    }
}
