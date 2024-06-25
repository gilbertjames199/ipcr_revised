<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUserEmployeeCredentials0620202024 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_employee_credentials', function (Blueprint $table) {
            $table->string('otp')->nullable()->after('email');
            $table->string('otp_created_at')->nullable()->after('otp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_employee_credentials', function (Blueprint $table) {
            //
        });
    }
}
