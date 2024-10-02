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
            $table->date('submitted_at')->after('status')->default(null);
            $table->date('resubmitted_at')->after('submitted_at')->default(null);
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
