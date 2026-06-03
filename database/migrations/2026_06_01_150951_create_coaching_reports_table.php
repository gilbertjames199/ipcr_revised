<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoachingReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('coaching_reports', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->string('employee_cats_id');
            $table->text('critical_incidence_description');
            $table->text('goal');
            $table->text('reality');
            $table->text('opportunities');
            $table->text('way_forward');
            $table->date('follow_up_date');
            $table->string('follow_up_time');
            $table->text('write_things_down');
            $table->string('coach_name');
            $table->string('position');
            $table->string('semester');
            $table->string('month');
            $table->string('year');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coaching_reports');
    }
}
