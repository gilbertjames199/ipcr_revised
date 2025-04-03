<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToDesignatedDivisionHeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('designated_division_heads', function (Blueprint $table) {
            $table->string('department_code')->nullable()->after('id')->comment('for chief of jhospital designates/department head designates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('designated_division_heads', function (Blueprint $table) {
            //
        });
    }
}
