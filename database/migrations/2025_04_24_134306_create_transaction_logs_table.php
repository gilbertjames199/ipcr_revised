<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impersonate_transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('impersonator_id')->nullable(); // real user
            $table->unsignedBigInteger('impersonated_id')->nullable(); // impersonated user
            $table->string('action'); // e.g. 'impersonation_started', 'impersonation_stopped'
            $table->text('description')->nullable();
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
        Schema::dropIfExists('transaction_logs');
    }
}
