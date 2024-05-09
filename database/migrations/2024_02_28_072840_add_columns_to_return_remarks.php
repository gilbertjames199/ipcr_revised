<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToReturnRemarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('return_remarks', function (Blueprint $table) {
            $table->string('acted_by')->after('employee_code')
                ->nullable()
                ->comment('id of the current user who reviewed/approved/returned IPCR accomplishment or target');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('return_remarks', function (Blueprint $table) {
            //
        });
    }
}
