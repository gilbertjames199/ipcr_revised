<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToMonthlyAccomplishmentsOctober2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr_monthly_accomplishments', function (Blueprint $table) {
            $table->string('submitted_at')->after('status')->default('')->nullable();
            $table->string('resubmitted_at')->after('submitted_at')->default('')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ipcr_monthly_accomplishments', function (Blueprint $table) {
            //
        });
    }
}
