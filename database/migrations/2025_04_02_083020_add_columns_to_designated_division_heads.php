<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToDesignatedDivisionHeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('designated_division_heads', function (Blueprint $table) {
            $table->string('type')->default('dpcr')->comment('dpcr -division head; spcr -section head, hpcr -hospital head')->after('added_by');
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
