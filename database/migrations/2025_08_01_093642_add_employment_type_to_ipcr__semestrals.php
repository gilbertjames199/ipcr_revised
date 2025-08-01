<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmploymentTypeToIpcrSemestrals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ipcr__semestrals', function (Blueprint $table) {
            $table->string('pcr_type')->nullable()->comment('div -division head, emp -caapitol employee,
                hemp -hospital employee, hdiv -hospital division head, hos -hospital chief, hsec -hospital section head');
            $table->softDeletes('deleted_at', 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ipcr__semestrals', function (Blueprint $table) {
            //
        });
    }
}
