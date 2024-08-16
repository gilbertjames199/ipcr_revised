<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCanBeImpersonatedColumnToUserEmployeeCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_employee_credentials', function (Blueprint $table) {
            $table->string('can_be_impersonated')->default(1)->comment('1 -can be impersonated, 0 -can\'t be impersonated');
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
