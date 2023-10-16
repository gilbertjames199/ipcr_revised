<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsFromToProbationaryTemporaryEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('probationary_temporary_employees', function (Blueprint $table) {
            $table->json('date_from')->after('no_of_months');
            $table->json('date_to')->after('date_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('probationary_temporary_employees', function (Blueprint $table) {
            //
        });
    }
}
