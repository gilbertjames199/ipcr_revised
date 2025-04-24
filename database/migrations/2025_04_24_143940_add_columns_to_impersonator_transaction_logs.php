<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToImpersonatorTransactionLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('impersonate_transaction_logs', function (Blueprint $table) {
            $table->string('table_name')->after('action')->nullable();
            $table->unsignedBigInteger('row_id')->after('table_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('impersonator_transaction_logs', function (Blueprint $table) {
            //
        });
    }
}
